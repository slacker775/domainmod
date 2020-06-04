<?php
namespace App\Repository;

use App\Entity\CreationType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CreationTypeRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreationType::class);
    }
    
    public function findByName(string $name): CreationType
    {
        return $this->createQueryBuilder('c')
            ->where('c.name=:name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getSingleResult();
    }
}