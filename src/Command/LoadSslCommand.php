<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\CreationType;
use App\Entity\Domain;
use App\Entity\IpAddress;
use App\Entity\Owner;
use App\Entity\SslAccount;
use App\Entity\SslCert;
use App\Entity\SslCertType;
use App\Entity\SslProvider;
use App\Repository\CreationTypeRepository;
use App\Repository\SslCertRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use SimpleXMLElement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LoadSslCommand extends Command
{

    protected static $defaultName = 'app:load:ssl';

    private EntityManagerInterface $entityManager;

    private SslCertRepository $certRepository;

    private CreationTypeRepository $creationTypeRepository;

    private array $owners;

    private array $providers;

    private array $accounts;

    private array $thumbprints;

    private CreationType $creationType;

    private Category $category;

    private IpAddress $ipAddress;

    private SslCertType $type;

    public function __construct(EntityManagerInterface $entityManager, SslCertRepository $certRepository, CreationTypeRepository $creationTypeRepository)
    {
        $this->entityManager = $entityManager;
        $this->certRepository = $certRepository;
        $this->creationTypeRepository = $creationTypeRepository;

        $this->owners = [];
        $this->providers = [];
        $this->accounts = [];
        $this->thumbprints = [];

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Import SSL Certificates from Nmap results')
            ->addArgument('file', InputArgument::REQUIRED, 'Nmap XML to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filename = $input->getArgument('file');

        $count = 0;

        $this->category = $this->entityManager->getRepository(Category::class)
            ->findOneByName('[no category]');
        $this->ipAddress = $this->entityManager->getRepository(IpAddress::class)
            ->findOneByName(['[no ip address]']);
        $this->creationType = $this->creationTypeRepository->findByName('Import');
        $this->type = $this->entityManager->getRepository(SslCertType::class)->findOneByType('Web Server SSL/TLS Certificate');

        $xml = simplexml_load_file($filename);

        $results = $xml->xpath("/nmaprun/host/ports/port/script[@id='ssl-cert']");
        foreach ($results as $script) {
            $data['commonName'] = $this->getDataFromXpath($script, "table[@key='subject']/elem[@key='commonName']");
            $data['organization'] = $this->getDataFromXpath($script, "table[@key='subject']/elem[@key='organizationName']");
            $data['issuer'] = $this->getDataFromXpath($script, "table[@key='issuer']/elem[@key='organizationName']");
            $data['notBefore'] = new DateTime($this->getDataFromXpath($script, "table[@key='validity']/elem[@key='notBefore']"));
            $data['notAfter'] = new DateTime($this->getDataFromXpath($script, "table[@key='validity']/elem[@key='notAfter']"));
            $data['thumbprint'] = $this->getDataFromXpath($script, "elem[@key='sha1']");

            try {
                $this->loadCert($data);
                $count++;
            } catch (Exception $e) {
                $io->warning($e->getMessage());
            }
        }

        $this->entityManager->flush();
        $io->writeln(sprintf('Imported %d certificate(s)', $count));
        return 0;
    }

    private function getDataFromXpath(SimpleXMLElement $xml, string $path): ?string
    {
        $result = $xml->xpath($path);
        if ($result === false || empty($result)) {
            return null;
        }
        return (string)$result[0];
    }

    private function loadCert(array $data): void
    {
        if (in_array($data['thumbprint'], $this->thumbprints) === false) {
            $cert = new SslCert();

            $domain = $this->getDomain($data['commonName']);
            $owner = $this->getOwner($data['organization']);
            $provider = $this->getProvider($data['issuer']);
            $account = $this->getSslAccount($provider, $owner);

            $cert->setName($data['commonName'])
                ->setDomain($domain)
                ->setAccount($account)
                ->setThumbprint($data['thumbprint'])
                ->setExpiryDate($data['notAfter'])
                ->setCategory($this->category)
                ->setType($this->type)
                ->setIp($this->ipAddress)
                ->setCreatedBy('import')
                ->setCreationType($this->creationType)
                ->setNotes(sprintf('Imported - %s', date('m/d/Y')));
            $this->certRepository->save($cert);
            $this->thumbprints[] = $data['thumbprint'];
        }
        //throw new Exception(sprintf("Certificate already exists for thumbprint %s", $data['thumbprint']));
    }

    private function getDomain(string $commonName): Domain
    {
        if (filter_var($commonName, FILTER_VALIDATE_IP)) {
            throw new Exception(sprintf("Certificate common name is an IP address - %s", $commonName));
        }

        if (substr_count($commonName, '.') == 1) {
            /* If there is only 1 period in the CN, add one so the regex later works properly */
            $commonName = '.' . $commonName;
        }

        $re = '#\.(?<domain>\S+\.\S+)$#';
        if (preg_match($re, $commonName, $matches)) {
            $domainName = $matches[1];
            $domain = $this->entityManager->getRepository(Domain::class)
                ->findOneByName($domainName);
            if ($domain === null) {
                throw new Exception(sprintf("Unable to find domain %s", $domainName));
            }
            return $domain;
        }

        throw new Exception(sprintf("Common Name is improper - %s", $commonName));
    }

    private function getOwner(?string $owner): Owner
    {
        if ($owner === null || $owner === '') {
            if (isset($this->owners['[no owner]']) == true) {
                return $this->owners['[no owner]'];
            }
            $obj = $this->entityManager->getRepository(Owner::class)
                ->findOneByName('[no owner]');
            return $obj;
        }

        if (isset($this->owners[$owner]) == false) {
            $obj = $this->entityManager->getRepository(Owner::class)
                ->findOneByName($owner);
            if ($obj !== null) {
                $this->owners[$owner] = $obj;
            }
        }

        if (isset($this->owners[$owner]) == true) {
            return $this->owners[$owner];
        }

        $obj = new Owner();
        $obj->setName($owner)
            ->setCreationType($this->creationType);
        $this->owners[$owner] = $obj;
        $this->entityManager->persist($obj);
        return $obj;
    }

    private function getSslAccount(SslProvider $provider, Owner $owner): SslAccount
    {
        $slug = sprintf("%s-%s", $owner->getName(), $provider->getName());

        if (isset($this->accounts[$slug]) == true) {
            return $this->accounts[$slug];
        }

        $obj = new SslAccount();
        $obj->setUsername('[created by import]')
            ->setSslProvider($provider)
            ->setOwner($owner)
            ->setCreationType($this->creationType)
            ->setCreatedBy('import')
            ->setNotes(sprintf('Created by import - %s', date('m/d/Y')));
        $this->accounts[$slug] = $obj;
        $this->entityManager->persist($obj);

        return $obj;
    }

    private function getProvider(string $provider): SslProvider
    {
        if ($provider == null || $provider == '') {
            $provider = '[no provider]';
        }
        if (isset($this->providers[$provider]) == false) {
            $obj = $this->entityManager->getRepository(SslProvider::class)
                ->findOneByName($provider);
            if ($obj !== null) {
                $this->providers[$provider] = $obj;
            }
        }

        if (isset($this->providers[$provider]) == true) {
            return $this->providers[$provider];
        }

        $obj = new SslProvider();
        $obj->setName($provider)
            ->setCreatedBy('import')
            ->setCreationType($this->creationType);
        $this->providers[$provider] = $obj;
        $this->entityManager->persist($obj);

        return $obj;
    }
}
