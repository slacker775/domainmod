<?php
declare(strict_types = 1);
namespace App\Repository;

use App\Entity\Dns;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DnsRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dns::class);
    }

    public function save(Dns $dns)
    {
        $this->getEntityManager()->persist($dns);
    }

    public function remove(Dns $dns)
    {
        $this->getEntityManager()->remove($dns);
    }
}