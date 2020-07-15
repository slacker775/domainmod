<?php
namespace App\Repository;

use App\Entity\RegistrarAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RegistrarAccountRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegistrarAccount::class);
    }
    
    public function getAccountsWithApi(): array
    {
        $query = $this->getEntityManager()->createQuery('SELECT a FROM App\Entity\RegistrarAccount a JOIN a.registrar r JOIN r.apiRegistrar api ' . 
            'WHERE r.apiRegistrar IS NOT null ORDER BY r.name,a.owner,a.username');
        return $query->getResult();
    }
}