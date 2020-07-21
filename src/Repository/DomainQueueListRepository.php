<?php
namespace App\Repository;

use App\Entity\DomainQueueList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DomainQueueListRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DomainQueueList::class);
    }

    public function save(DomainQueueList $q)
    {
        $this->getEntityManager()->persist($q);
    }

    public function remove(DomainQueueList $q)
    {
        $this->getEntityManager()->remove($q);
    }

    public function getAllReadyToProcess(): array
    {
        $query = $this->getEntityManager()->createQuery('SELECT d FROM App\Entity\DomainQueueList d WHERE ' . 'd.processing=false AND d.readyToImport=false AND d.finished=false AND d.copiedToHistory=false ORDER BY d.createdAt DESC');
        return $query->getResult();
    }

    public function markProcessingList()
    {
        $query = $this->getEntityManager()->createQuery('UPDATE App\Entity\DomainQueueList d SET d.processing=true WHERE ' . 'd.processing=false AND d.readyToImport=false AND d.finished=false AND d.copiedToHistory=false');
        $query->getResult();
    }

    public function markCopiedToHistory()
    {
        $query = $this->getEntityManager()->createQuery('UPDATE App\Entity\DomainQueueList d SET d.copiedToHistory=true WHERE d.finished=true AND d.copiedToHistory=false');
        $query->getResult();
    }
}