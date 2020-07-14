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
    
    public function save(DomainQueue $q): void
    {
        $this->getEntityManager()->persist($q);
    }
    
    public function remove(DomainQueue $q): void
    {
        $this->getEntityManager()->remove($q);
    }
    
    public function markProcessingQueue(): void
    {
        $query = $this->getEntityManager()->createQuery('UPDATE App\Entity\DomainQueue q SET q.processing=true WHERE ' . 
            'q.processing=false AND q.readyToImport=false AND q.finished=false AND q.copiedToHistory=false AND q.alreadyInDomains=false');
        $query->getResult();
    }    
    
    public function getAllReadyToProcess(): array
    {
        $query = $this->getEntityManager()->createQuery('SELECT q FROM App\Entity\DomainQueue q WHERE ' . 
            'q.processing=false AND q.readyToImport=false AND q.finished=false AND q.copiedToHistory=false AND q.alreadyInDomains=false AND q.alreadyInQueue=false');
        return $query->getResult();
    }
}