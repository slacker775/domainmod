<?php
namespace App\Repository;

use App\Entity\DomainQueue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class QueueRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DomainQueue::class);
    }

    public function save(DomainQueue $queue)
    {
        $this->getEntityManager()->persist($queue);
    }

    public function getPendingCount(): int
    {
        $query = $this->getEntityManager()->createQuery('SELECT COUNT(q) FROM App\Entity\DomainQueue q WHERE q.processing = false AND q.finished = false');
        return $query->getSingleScalarResult();
    }

    public function getProcessingCount(): int
    {
        $query = $this->getEntityManager()->createQuery('SELECT COUNT(q) FROM App\Entity\DomainQueue q WHERE q.processing = true AND q.finished = false');
        return $query->getSingleScalarResult();
    }

    public function getFinishedCount(): int
    {
        $query = $this->getEntityManager()->createQuery('SELECT COUNT(q) FROM App\Entity\DomainQueue q WHERE q.finished = true');
        return $query->getSingleScalarResult();
    }
}