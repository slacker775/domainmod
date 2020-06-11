<?php
namespace App\Repository;

use App\Entity\DomainQueue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DomainQueueRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DomainQueue::class);
    }
    
    public function save(DomainQueue $q)
    {
        $this->getEntityManager()->persist($q);
    }
    
    public function remove(DomainQueue $q)
    {
        $this->getEntityManager()->remove($q);
    }
}