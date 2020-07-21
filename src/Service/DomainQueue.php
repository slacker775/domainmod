<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Dns;
use App\Entity\Domain;
use App\Entity\DomainQueue as DomainQueueEntity;
use App\Entity\DomainQueueHistory;
use App\Entity\DomainQueueList;
use App\Entity\DomainQueueListHistory;
use App\Entity\Hosting;
use App\Entity\IpAddress;
use App\Entity\RegistrarAccount;
use App\Repository\CreationTypeRepository;
use App\Repository\DomainQueueListRepository;
use App\Repository\DomainQueueRepository;
use App\Service\ApiRegistrar\ApiRegistrarInterface;
use App\Service\ApiRegistrar\GoDaddy;
use App\Service\ApiRegistrar\Route53;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class DomainQueue implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private EntityManagerInterface $entityManager;

    private DomainQueueRepository $domainQueueRepository;

    private DomainQueueListRepository $domainQueueListRepository;

    private CreationTypeRepository $creationTypeRepository;

    public function __construct(EntityManagerInterface $entityManager, DomainQueueRepository $domainQueueRepository, DomainQueueListRepository $domainQueueListRepository, CreationTypeRepository $creationTypeRepository)
    {
        $this->entityManager = $entityManager;
        $this->domainQueueRepository = $domainQueueRepository;
        $this->domainQueueListRepository = $domainQueueListRepository;
        $this->creationTypeRepository = $creationTypeRepository;
    }

    public function run(): void
    {
        $this->processDomainQueueList();
        $this->processDomainQueue();
    }

    private function processDomainQueueList(): void
    {
        $queue = $this->domainQueueListRepository->getAllReadyToProcess();

        if ($queue == null) {
            $this->logger->info('No Domain Queue Lists to process');
            return;
        }
        $this->logger->notice('[START] Processing Domain Queue Lists');

        foreach ($queue as $q) {
            $q->setProcessing(true);
            $this->domainQueueListRepository->save($q);
            $this->entityManager->flush();

            $this->logger->info(sprintf('Processing domain from list %s', $q->getAccount()));

            $service = $this->getApiRegistrarService($q->getAccount());

            try {
                $domains = $service->listDomains();
                $domainCount = count($domains);

                if ($domainCount > 0) {
                    $q->setDomainCount($q->getDomainCount() + $domainCount);
                    $this->domainQueueListRepository->save($q);

                    foreach ($domains as $domain) {
                        $this->importToDomainQueue($domain, $q);
                    }

                    $q->setProcessing(false)
                        ->setReadyToImport(true)
                        ->setFinished(true);
                } else {
                    $q->setProcessing(false);
                }
                $this->domainQueueListRepository->save($q);
            } catch (Exception $e) {
                $this->logger->error(sprintf('Exception thrown while listing domains: %s', $e->getMessage()));
                $q->setProcessing(false);
                $this->domainQueueListRepository->save($q);
                $this->entityManager->flush();
            }
        }
        $this->logger->notice('[END] Processing Domain Queue Lists');

        $this->entityManager->flush();

        $this->copyToHistoryList();

        $this->entityManager->flush();
    }

    private function getApiRegistrarService(RegistrarAccount $account): ApiRegistrarInterface
    {
        $apiRegistrar = $account->getRegistrar()
            ->getApiRegistrar()
            ->getName();
        if ($apiRegistrar === null) {
            throw new Exception('API Registrar not defined!');
        }

        $service = null;
        switch (strtolower($apiRegistrar)) {
            case 'godaddy':
                $service = new GoDaddy();
                $service->setCredentials([
                    'apiKey' => $account->getApiKey(),
                    'apiSecret' => $account->getApiSecret()
                ]);
                break;
            case 'aws route53':
                $service = new Route53();
                $service->setCredentials([
                    'apiName' => $account->getApiAppName(),
                    'apiKey' => $account->getApiKey(),
                    'apiSecret' => $account->getApiSecret(),
                    'apiToken' => $account->getApiToken()
                ]);
                break;
            default:
                throw new Exception(sprintf('Unknown API registrar type specified: %s', $apiRegistrar));
        }
        return $service;
    }

    private function importToDomainQueue(string $domain, DomainQueueList $ql): void
    {
        $this->logger->debug(sprintf('[IMPORT] Importing domain %s to domain queue for processing', $domain));

        $domainEntry = $this->entityManager->getRepository(Domain::class)
            ->findOneByName($domain);

        $defaultCategory = $this->entityManager->getRepository(Category::class)
            ->findOneByName('[no category]');
        $defaultDns = $this->entityManager->getRepository(Dns::class)
            ->findOneByName('[no dns]');
        $defaultIp = $this->entityManager->getRepository(IpAddress::class)
            ->findOneByName('[no ip address]');
        $defaultHosting = $this->entityManager->getRepository(Hosting::class)
            ->findOneByName('[no hosting]');

        if ($domainEntry !== null) {
            /* Domain is already in the domains table */

            $dq = new DomainQueueEntity();
            $dq->setDomain($domainEntry)
                ->setTld($domainEntry->getTld())
                ->setDomainName($domain)
                ->setAccount($ql->getAccount())
                ->setRegistrar($ql->getRegistrar())
                ->setOwner($ql->getOwner())
                ->setApiRegistrar($ql->getApiRegistrar())
                ->setAlreadyInDomains(true)
                ->setProcessing(false)
                ->setReadyToImport(true)
                ->setFinished(true)
                ->setCategory($defaultCategory)
                ->setDns($defaultDns)
                ->setIp($defaultIp)
                ->setHosting($defaultHosting)
                ->setCreatedBy($ql->getCreatedBy());
            $this->domainQueueRepository->save($dq);
        } else {
            /* Domain is NOT in the domains table, lets make sure its not already in the queue */
            $domainQueueEntry = $this->entityManager->getRepository(DomainQueueEntity::class)
                ->findOneByDomainName($domain);

            if (($domainQueueEntry !== null) && ($domainEntry !== null)) {
                $dq = new DomainQueueEntity();
                $dq->setDomain($domainEntry)
                    ->setTld($domainEntry->getTld())
                    ->setDomainName($domain)
                    ->setAccount($ql->getAccount())
                    ->setRegistrar($ql->getRegistrar())
                    ->setOwner($ql->getOwner())
                    ->setApiRegistrar($ql->getApiRegistrar())
                    ->setAlreadyInDomains(true)
                    ->setProcessing(false)
                    ->setReadyToImport(true)
                    ->setFinished(true)
                    ->setCategory($defaultCategory)
                    ->setDns($defaultDns)
                    ->setIp($defaultIp)
                    ->setHosting($defaultHosting)
                    ->setCreatedBy($ql->getCreatedBy());
                $this->domainQueueRepository->save($dq);
            } else {
                /* Domain not already in domain table and NOT in domain queue */
                $dq = new DomainQueueEntity();
                $dq->setTld($this->getTld($domain))
                    ->setDomainName($domain)
                    ->setAccount($ql->getAccount())
                    ->setRegistrar($ql->getRegistrar())
                    ->setOwner($ql->getOwner())
                    ->setApiRegistrar($ql->getApiRegistrar())
                    ->setCategory($defaultCategory)
                    ->setDns($defaultDns)
                    ->setIp($defaultIp)
                    ->setHosting($defaultHosting)
                    ->setCreatedBy($ql->getCreatedBy());
                $this->domainQueueRepository->save($dq);
            }
        }
    }

    private function getTld(string $domain): string
    {
        return preg_replace("/^((.*?)\.)(.*)$/", "\\3", $domain);
    }

    private function copyToHistoryList(): void
    {
        $entries = $this->domainQueueListRepository->findBy([
            'finished' => true,
            'copiedToHistory' => false
        ], [
            'createdAt' => 'ASC'
        ]);

        if (count($entries) > 0) {
            foreach ($entries as $entry) {
                $dqh = new DomainQueueListHistory();
                $dqh->setDomainCount($entry->getDomainCount())
                    ->setApiRegistrar($entry->getApiRegistrar())
                    ->setRegistrar($entry->getRegistrar())
                    ->setOwner($entry->getOwner())
                    ->setAccount($entry->getAccount())
                    ->setCreatedBy($entry->getCreatedBy());
                $this->entityManager->persist($dqh);
            }
            $this->domainQueueListRepository->markCopiedToHistory();
            $this->entityManager->flush();
        } else {
            $this->logger->info('No Domain Queue List results to copy to history table');
        }
    }

    private function processDomainQueue(): void
    {
        $queue = $this->domainQueueRepository->getAllReadyToProcess();

        $this->domainQueueRepository->markProcessingQueue();

        if (count($queue) > 0) {
            $this->logger->notice('[START] Processing domains in the Domain Queue');

            foreach ($queue as $q) {
                $this->logger->info(sprintf('Processing domain %s', $q->getDomainName()));

                $this->logger->debug(sprintf('Using API Registrar: %s', $q->getApiRegistrar()));

                $service = $this->getApiRegistrarService($q->getAccount());

                $details = $service->getDomain($q->getDomainName());

                $q->setExpiryDate($details['expirationDate'])
                    ->setPrivacy($details['privacyStatus'])
                    ->setAutorenew($details['autorenewStatus'])
                    ->setHosting($this->getDefaultHosting())
                    ->setCategory($this->getDefaultCategory())
                    ->setDns($this->getDns($details['dnsServers']))
                    ->setIp($this->getIpAddress($q->getDomainName()))
                    ->setReadyToImport(true);

                if ($q->isReadyToImport() == true && $q->isAlreadyInQueue() == false && $q->isAlreadyInDomains() == false) {
                    $this->logger->info(sprintf('Importing domain %s into domain table', $q->getDomainName()));

                    $domain = $this->DomainQueueToEntity($q);

                    $q->setDomain($domain)
                        ->setFinished(true)
                        ->setProcessing(false);
                    $this->domainQueueRepository->save($q);
                }
            }
            $this->logger->notice('[END] Processing domains in the Domain Queue');
        } else {
            $this->logger->info('No domains in the Domain Queue to process');
        }

        $this->entityManager->flush();

        $this->copyToHistoryDomain();

        $this->entityManager->flush();
    }

    private function getDefaultHosting(): Hosting
    {
        $hosting = $this->entityManager->getRepository(Hosting::class)
            ->findOneByName('[no hosting]');
        if ($hosting !== null) {
            return $hosting;
        }

        $creationType = $this->creationTypeRepository->findByName('Queue');
        $hosting = new Hosting();
        $hosting->setName('[no hosting]')
            ->setCreationType($creationType)
            ->setCreatedBy('admin');
        $this->entityManager->persist($hosting);
        return $hosting;
    }

    private function getDefaultCategory(): Category
    {
        $category = $this->entityManager->getRepository(Category::class)
            ->findOneByName('[no category]');
        if ($category !== null) {
            return $category;
        }

        $creationType = $this->creationTypeRepository->findByName('Queue');
        $category = new Category();
        $category->setName('[no category]')
            ->setCreationType($creationType)
            ->setCreatedBy('admin');
        $this->entityManager->persist($category);
        return $category;
    }

    private function getDns(array $dns): Dns
    {
        $obj = $this->entityManager->getRepository(Dns::class)
            ->findOneByName('[no dns]');
        return $obj;

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
                $obj = $this->entityManager->getRepository(Dns::class)
                    ->findOneByName($slug);
            } else {
                $obj = $this->entityManager->getRepository(Dns::class)
                    ->findOneBy([
                        'dns1' => $hosts[0],
                        'dns2' => $hosts[1]
                    ]);
            }
            if ($obj !== null) {
                $this->dns[$slug] = $obj;
            }
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

    private function getIpAddress(string $domain): IpAddress
    {
        /* Fixme - Add some DNS resolution logic in here to try to identify the IP */
        $ip = $this->entityManager->getRepository(IpAddress::class)
            ->findOneByName('[no ip address]');
        return $ip;
    }

    private function DomainQueueToEntity(DomainQueueEntity $q): Domain
    {
        $domain = new Domain();
        $domain->setName($q->getDomainName())
            ->setTld($q->getTld())
            ->setExpiryDate($q->getExpiryDate())
            ->setRegistrar($q->getRegistrar())
            ->setAccount($q->getAccount())
            ->setOwner($q->getOwner())
            ->setHostingProvider($q->getHosting())
            ->setIp($q->getIpAddress())
            ->setDns($q->getDns())
            ->setCategory($q->getCategory())
            ->setAutorenew($q->isAutorenew())
            ->setPrivacy($q->isPrivacy())
            ->setNotes(sprintf('%s - imported by queue', strftime('%m/%d/%Y')))
            ->setCreatedBy($q->getCreatedBy())
            ->setCreationType($this->creationTypeRepository->findByName('Queue'));
        return $domain;
    }

    private function copyToHistoryDomain(): void
    {
        $entries = $this->domainQueueRepository->findBy([
            'finished' => true,
            'copiedToHistory' => false
        ], [
            'createdAt' => 'ASC'
        ]);

        if (count($entries) > 0) {
            foreach ($entries as $entry) {
                $dqh = new DomainQueueHistory();
                $dqh->setApiRegistrar($entry->getApiRegistrar())
                    ->setRegistrar($entry->getRegistrar())
                    ->setOwner($entry->getOwner())
                    ->setAccount($entry->getAccount())
                    ->setDomain($entry->getDomain())
                    ->setDomainName($entry->getDomainName())
                    ->setTld($entry->getTld())
                    ->setExpiryDate($entry->getExpiryDate())
                    ->setCategory($entry->getCategory())
                    ->setDns($entry->getDns())
                    ->setIpAddress($entry->getIpAddress())
                    ->setHosting($entry->getHosting())
                    ->setPrivacy($entry->isPrivacy())
                    ->setAutoRenew($entry->isAutoRenew())
                    ->setAlreadyInDomains($entry->isAlreadyInDomains())
                    ->setAlreadyInQueue($entry->isAlreadyInQueue())
                    ->setCreatedBy($entry->getCreatedBy());

                $entry->setCopiedToHistory(true);

                $this->entityManager->persist($dqh);
                $this->domainQueueRepository->save($entry);
            }
            $this->entityManager->flush();
        } else {
            $this->logger->info('No Domain Queue results to copy to history table');
        }
    }

    private function domainInMainTable(string $domain): bool
    {
        $result = $this->entityManager->getRepository(Domain::class)
            ->findOneByName($domain);
        return $result !== null;
    }
}