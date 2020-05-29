<?php
namespace App\Repository;

use App\Entity\SslCert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class SslCertRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SslCert::class);
    }

    public function getActiveCertificateCount(): int
    {
        $query = $this->getEntityManager()->createQuery("SELECT count(s) FROM App\Entity\SslCert s WHERE s.active NOT IN ('0','10')");
        return $query->getSingleScalarResult();
    }
}