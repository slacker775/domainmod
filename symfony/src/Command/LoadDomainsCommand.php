<?php
namespace App\Command;

use App\Entity\Domain;
use App\Entity\Owner;
use App\Entity\Registrar;
use App\Entity\RegistrarAccount;
use App\Repository\CreationTypeRepository;
use App\Repository\DomainRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Dns;
use App\Entity\Category;

class LoadDomainsCommand extends Command
{

    protected static $defaultName = 'app:load-domains';

    private EntityManagerInterface $entityManager;

    private DomainRepository $domainRepository;

    private CreationTypeRepository $creationTypeRepository;

    private $owners;

    private $registrars;

    private $accounts;

    private $dns;

    private $creationType;

    public function __construct(EntityManagerInterface $entityManager, DomainRepository $domainRepository, CreationTypeRepository $creationTypeRepository)
    {
        $this->entityManager = $entityManager;
        $this->domainRepository = $domainRepository;
        $this->creationTypeRepository = $creationTypeRepository;

        $this->owners = [];
        $this->registrars = [];
        $this->accounts = [];

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Load domain data from a CSV')->addArgument('file', InputArgument::REQUIRED, 'Filename to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filename = $input->getArgument('file');

        $category = $this->entityManager->getRepository(Category::class)->findOneByName('[no category]');
        
        $this->creationType = $this->creationTypeRepository->findByName('Import');
        $csv = Reader::createFromPath($filename, 'r');
        $csv->setHeaderOffset(0);

        $header = $csv->getHeader();
        foreach ($csv->getRecords($header) as $row) {
            $domain = $this->domainRepository->findOneBy([
                'domain' => $row['domain']
            ]);
            if ($domain === null) {
                $io->writeln(sprintf("Adding domain %s", $row['domain']));

                $owner = $this->getOwner($row['division']);
                $registrar = $this->getRegistrar($row['registrar']);
                $registrarAccount = $this->getRegistrarAccount($registrar, $owner);
                $dns = $this->getDns($row['nameservers']);

                $domain = new Domain();
                $domain->setDomain($row['domain'])
                    ->setCreationType($this->creationType)
                    ->setOwner($owner)
                    ->setAccount($registrarAccount)
                    ->setRegistrar($registrar)
                    ->setTld()
                    ->setDns($dns)->setCategory($category);

                if ($row['expires'] !== '') {
                    $expiry = new \DateTime($row['expires']);
                } else {
                    $expiry = new \DateTime('12/31/2025');
                }
                $domain->setExpiryDate($expiry);
                $this->domainRepository->save($domain);
            } else {
                $io->warning(sprintf("Skipping domain %s as it already exists", $row['domain']));
            }
        }
        $this->entityManager->flush();
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }

    private function getOwner(string $owner): Owner
    {
        if ($owner === null || $owner === '') {
            if (isset($this->owners['[no owner]']) == true) {
                return $this->owners['[no owner]'];
            }
            $obj = $this->entityManager->getRepository(Owner::class)->findOneByName('[no owner]');
            return $obj;
        }

        if (isset($this->owners[$owner]) == false) {
            $obj = $this->entityManager->getRepository(Owner::class)->findOneByName($owner);
            if ($obj !== null) {
                $this->owners[$owner] = $obj;
            }
        }

        if (isset($this->owners[$owner]) == true) {
            return $this->owners[$owner];
        }

        $obj = new Owner();
        $obj->setName($owner)->setCreationType($this->creationType);
        $this->owners[$owner] = $obj;
        $this->entityManager->persist($obj);
        return $obj;
    }

    private function getRegistrar(string $registrar): Registrar
    {
        if ($registrar == null || $registrar == '') {
            $registrar = '[no registrar]';
        }
        if (isset($this->registrars[$registrar]) == false) {
            $obj = $this->entityManager->getRepository(Registrar::class)->findOneByName($registrar);
            if ($obj !== null) {
                $this->registrars[$registrar] = $obj;
            }
        }

        if (isset($this->registrars[$registrar]) == true) {
            return $this->registrars[$registrar];
        }

        $obj = new Registrar();
        $obj->setName($registrar)->setCreationType($this->creationType);
        $this->registrars[$registrar] = $obj;
        $this->entityManager->persist($obj);

        return $obj;
    }

    private function getRegistrarAccount(Registrar $registrar, Owner $owner): RegistrarAccount
    {
        $slug = sprintf("%s-%s", $owner->getName(), $registrar->getName());

        if (isset($this->accounts[$slug]) == true) {
            return $this->accounts[$slug];
        }

        $obj = new RegistrarAccount();
        $obj->setUsername('[created by import]')
            ->setRegistrar($registrar)
            ->setOwner($owner)
            ->setCreationType($this->creationType);
        $this->accounts[$slug] = $obj;
        $this->entityManager->persist($obj);

        return $obj;
    }

    private function getDns(string $dns): Dns
    {
        if ($dns == null || $dns == '') {
            $dns = '[no dns]';
            $slug = '[no dns]';
        }

        $hosts = explode(',', $dns);
        $hosts = array_filter($hosts, function ($v) {
            return strtolower($v);
        });
        sort($hosts);
        $slug = implode(',', $hosts);

        if (isset($this->dns[$slug]) == false) {
            if ($slug == '[no dns]') {
                $obj = $this->entityManager->getRepository(Dns::class)->findOneByName($slug);
            } else {
                $obj = $this->entityManager->getRepository(Dns::class)->findOneBy([
                    'dns1' => $hosts[0],
                    'dns2' => $hosts[1]
                ]);
            }
            if ($obj !== null) {
                $this->dns[$slug] = $obj;
            }
        }

        if (isset($this->dns[$slug]) == true) {
            return $this->dns[$slug];
        }

        $obj = new Dns();
        $obj->setName($slug)
            ->setDns1($hosts[0])
            ->setDns2($hosts[1])
            ->setCreationType($this->creationType);
        $this->entityManager->persist($obj);
        $this->dns[$slug] = $obj;
        return $obj;
    }
}
