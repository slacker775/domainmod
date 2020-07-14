<?php
namespace App\Repository;

use App\Entity\Scheduler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class SchedulerRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scheduler::class);
    }
    
    public function save(Scheduler $schedule)
    {
        $this->getEntityManager()->persist($schedule);
    }

}