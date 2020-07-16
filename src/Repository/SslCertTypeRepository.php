<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\SslCertType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class SslCertTypeRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SslCertType::class);
    }

    public function save(SslCertType $type)
    {
        $this->getEntityManager()->persist($type);
    }

    public function remove(SslCertType $type)
    {
        $this->getEntityManager()->remove($type);
    }

}