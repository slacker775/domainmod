<?php
namespace App\Repository;

use App\Entity\Registrar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Fee;

class RegistrarRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Registrar::class);
    }

    public function getFeeByTld(Registrar $registrar, string $tld): Fee
    {
        $query = $this->getEntityManager()
            ->createQuery('SELECT f FROM App\Entity\Fee f WHERE f.tld=:tld AND f.registrar=:registrar ORDER BY f.updateTime DESC')
            ->setParameters([
            'tld' => $tld,
            'registrar' => $registrar
        ]);

        return $query->getSingleResult();
    }
}