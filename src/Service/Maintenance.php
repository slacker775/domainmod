<?php
declare(strict_types = 1);
namespace App\Service;

use App\Entity\Domain;
use App\Entity\Fee;
use App\Entity\SegmentData;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use App\Repository\DomainRepository;

class Maintenance implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private EntityManagerInterface $entityManager;

    private DomainRepository $domainRepository;

    public function __construct(EntityManagerInterface $entityManager, DomainRepository $domainRepository)
    {
        $this->entityManager = $entityManager;
        $this->domainRepository = $domainRepository;
    }

    public function Maintenance()
    {
        $this->logger->info(sprintf("Maintenance Beginning"));

        $this->lowercaseDomains();
        $this->lowercaseFeeTlds();

        $this->updateDomainFees();

        $this->entityManager->flush();
        $this->logger->info(sprintf("Maintenance Complete"));
    }

    private function lowercaseDomains()
    {
        $this->logger->info(sprintf("Maintenance Task: Lowercasing all domain names"));

        $domains = $this->domainRepository->findAll();
        foreach ($domains as $d) {
            $d->setDomain(strtolower($d->getDomain()));

            $d->setTld($this->getTld($d->getDomain()));

            $this->domainRepository->save($d);
        }
    }

    private function getTld(string $domain): string
    {
        return preg_replace("/^((.*?)\.)(.*)$/", "\\3", $domain);
    }

    private function lowercaseFeeTlds()
    {
        $this->logger->info(sprintf("Maintenance Task: Lowercasing all TLDs in fees"));
        $fees = $this->entityManager->getRepository(Fee::class)->findAll();

        foreach ($fees as $f) {
            $f->setTld(strtolower($f->getTld()));

            $this->entityManager->persist($f);
        }
    }

    private function updateSegments()
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

    private function updateDomainFees()
    {
        $this->logger->info(sprintf("Maintenance Task: Updating domain fees"));
        $domains = $this->domainRepository->findAll();
        foreach ($domains as $d) {
            $this->domainRepository->updateDomainFees($d);
        }
    }
}