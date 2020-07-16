<?php
declare(strict_types=1);
namespace App\Repository;

use App\Entity\Fee;
use App\Entity\Registrar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NoResultException;

class RegistrarRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Registrar::class);
    }

    public function save(Registrar $registrar)
    {
        $this->getEntityManager()->persist($registrar);
    }
    
    public function remove(Registrar $registrar)
    {
        $this->getEntityManager()->remove($registrar);
    }
    
    public function getFeeByTld(Registrar $registrar, string $tld): ?Fee
    {
        $query = $this->getEntityManager()
            ->createQuery('SELECT f FROM App\Entity\Fee f WHERE f.tld=:tld AND f.registrar=:registrar ORDER BY f.updatedAt DESC')
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