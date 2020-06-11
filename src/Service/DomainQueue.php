<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\DomainQueueList;
use App\Repository\DomainQueueListRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use App\Service\ApiRegistrar\GoDaddy;
use App\Entity\Domain;
use App\Entity\DomainQueue as DomainQueueEntity;
use App\Entity\Category;
use App\Entity\Dns;
use App\Entity\IpAddress;
use App\Entity\Hosting;
use App\Entity\DomainQueueListHistory;

class DomainQueue implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private EntityManagerInterface $entityManager;

    private DomainQueueListRepository $domainQueueListRepository;

    public function __construct(EntityManagerInterface $entityManager, DomainQueueListRepository $domainQueueListRepository)
    {
        $this->entityManager = $entityManager;
        $this->domainQueueListRepository = $domainQueueListRepository;
    }

    public function run()
    {
        $this->processDomainQueueList();
    }

    private function processDomainQueueList()
    {
        $queue = $this->domainQueueListRepository->getAllReadyToProcess();

        if ($queue == null) {
            $this->logger->info('No Domain Queue Lists to process');
            return;
        }
        $this->logger->notice('[START] Processing Domain Queue Lists');

        $this->domainQueueListRepository->markProcessingList();

        foreach ($queue as $q) {
            $this->logger->info(sprintf('Processing: %s', $q->getAccount()));

            if (strtolower($q->getRegistrar()) == 'godaddy') {
                $service = new GoDaddy();
                $service->setCredentials([
                    'apiKey' => $q->getAccount()
                        ->getApiKey(),
                    'apiSecret' => $q->getAccount()
                        ->getApiSecret()
                ]);
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
            }
        }
        $this->logger->notice('[END] Processing Domain Queue Lists');

        $this->copyToHistoryList();

        $this->entityManager->flush();
    }

    private function importToDomainQueue(string $domain, DomainQueueList $ql)
    {
        $this->logger->debug(sprintf('[IMPORT] Importing domain %s to domain queue for processing', $domain));

        $domainEntry = $this->entityManager->getRepository(Domain::class)->findOneByDomain($domain);

        $defaultCategory = $this->entityManager->getRepository(Category::class)->findOneByName('[no category]');
        $defaultDns = $this->entityManager->getRepository(Dns::class)->findOneByName('[no dns]');
        $defaultIp = $this->entityManager->getRepository(IpAddress::class)->findOneByName('[no ip address]');
        $defaultHosting = $this->entityManager->getRepository(Hosting::class)->findOneByName('[no hosting]');

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
            $this->entityManager->persist($dq);
        } else {
            /* Domain is NOT in the domains table, lets make sure its not already in the queue */
            $domainQueueEntry = $this->entityManager->getRepository(DomainQueueEntity::class)->findOneByDomainName($domain);

            if ($domainQueueEntry !== null) {
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
                $this->entityManager->persist($dq);
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
                $this->entityManager->persist($dq);
            }
        }
    }

    private function copyToHistoryList()
    {
        $entries = $this->domainQueueListRepository->findBy([
            'finished' => true,
            'copiedToHistory' => false
        ], [
            'created' => 'ASC'
        ]);

        if ($entries !== null) {
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
            $this->log->info('No Domain Queue List results to copy to history table');
        }
    }

    private function domainInMainTable(string $domain): bool
    {
        $result = $this->entityManager->getRepository(Domain::class)->findOneByName($domain);
        return $result !== null;
    }

    private function getTld(string $domain): string
    {
        return preg_replace("/^((.*?)\.)(.*)$/", "\\3", $domain);
    }
}