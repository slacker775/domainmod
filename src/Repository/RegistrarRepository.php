<?php
namespace App\Repository;

use App\Entity\Registrar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Fee;
use Doctrine\ORM\NoResultException;

class RegistrarRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Registrar::class);
    }

    public function getFeeByTld(Registrar $registrar, string $tld): ?Fee
    {
        $query = $this->getEntityManager()
            ->createQuery('SELECT f FROM App\Entity\Fee f WHERE f.tld=:tld AND f.registrar=:registrar ORDER BY f.updated DESC')
            ->setParameters([
            'tld' => $tld,
            'registrar' => $registrar
        ]);

        try {
            $result = $query->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
        return $result;
    }

    public function getMissingFees(): array
    {
        $query = $this->getEntityManager()->createQuery('SELECT r.id,r.name,d.tld FROM App\Entity\Domain d JOIN d.registrar r WHERE d.fee = 0 OR d.fee IS NULL');
        return $query->getResult();
    }
}