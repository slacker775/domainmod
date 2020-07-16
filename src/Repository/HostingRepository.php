<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Hosting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class HostingRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hosting::class);
    }

    public function save(Hosting $hosting)
    {
        $this->getEntityManager()->persist($hosting);
    }

    public function remove(Hosting $hosting)
    {
        $this->getEntityManager()->remove($hosting);
    }

}