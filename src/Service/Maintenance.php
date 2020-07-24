<?php
declare(strict_types = 1);
namespace App\Service;

use App\Entity\Domain;
use App\Entity\Fee;
use App\Entity\SegmentData;
use App\Event\DomainExpired;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use App\Repository\DomainRepository;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class Maintenance implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private EntityManagerInterface $entityManager;

    private DomainRepository $domainRepository;

    private EventDispatcherInterface $dispatcher;

    public function __construct(EntityManagerInterface $entityManager, EventDispatcherInterface $dispatcher, DomainRepository $domainRepository)
    {
        $this->entityManager = $entityManager;
        $this->dispatcher = $dispatcher;
        $this->domainRepository = $domainRepository;
    }

    public function Maintenance(): void
    {
        $this->logger->info(sprintf("Maintenance Beginning"));

        $this->lowercaseDomains();
        $this->lowercaseFeeTlds();

        $this->updateDomainFees();

        $this->expireDomains();

        $this->entityManager->flush();
        $this->logger->info(sprintf("Maintenance Complete"));
    }

    private function expireDomains(): void
    {
        $expiredDomains = [];
        $domains = $this->domainRepository->getExpiringDomains(0);
        foreach($domains as $domain) {
            //$domain->setStatus(Domain::STATUS_EXPIRED);
            $expiredDomains[] = $domain;
            //$this->domainRepository->save($domain);
        }

        $event = new DomainExpired($expiredDomains);
        $this->dispatcher->dispatch($event, DomainExpired::NAME);
    }

    private function lowercaseDomains(): void
    {
        $this->logger->info(sprintf("Maintenance Task: Lowercasing all domain names"));

        $domains = $this->domainRepository->findAll();
        foreach ($domains as $d) {
            $d->setName(strtolower($d->getName()));

            $d->setTld($this->getTld($d->getName()));

            $this->domainRepository->save($d);
        }
    }

    private function getTld(string $domain): string
    {
        return preg_replace("/^((.*?)\.)(.*)$/", "\\3", $domain);
    }

    private function lowercaseFeeTlds(): void
    {
        $this->logger->info(sprintf("Maintenance Task: Lowercasing all TLDs in fees"));
        $fees = $this->entityManager->getRepository(Fee::class)->findAll();
        foreach ($fees as $f) {
            $tld = $f->getTld();
            if ($tld !== null) {
                $f->setTld(strtolower($tld));

                $this->entityManager->persist($f);
            }
        }
    }

    private function updateSegments(): void
    {
        $this->logger->info(sprintf("Maintenance Task: Updating domain segments"));

        $segments = $this->entityManager->getRepository(SegmentData::class)->findAll();

        foreach ($segments as $s) {
            $s->setActive(false)
                ->setInactive(false)
                ->setMissing(false)
                ->setFiltered(false);

            $domain = $this->entityManager->getRepository(Domain::class)->findOneBy([
                'domain' => $s->getDomain()
            ]);

            if ($domain === null) {
                $s->setMissing();
            } else {
                $status = $domain->getStatus();

                if (in_array($status, [
                    Domain::STATUS_EXPIRED,
                    Domain::STATUS_SOLD
                ]) == false) {
                    $s->setActive();
                } elseif (in_array($status, [
                    Domain::STATUS_EXPIRED,
                    Domain::STATUS_SOLD
                ]) == true) {
                    $s->setInactive();
                }
            }

            $this->entityManager->persist($s);
        }
    }

    private function updateDomainFees(): void
    {
        $this->logger->info(sprintf("Maintenance Task: Updating domain fees"));
        $domains = $this->domainRepository->findAll();
        foreach ($domains as $d) {
            $this->domainRepository->updateDomainFees($d);
        }
    }
}