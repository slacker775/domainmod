<?php
declare(strict_types = 1);
namespace App\Repository;

use App\Entity\Owner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class OwnerRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Owner::class);
    }

    public function save(Owner $owner)
    {
        $this->getEntityManager()->persist($owner);
    }

    public function remove(Owner $owner)
    {
        $this->getEntityManager()->remove($owner);
    }
}