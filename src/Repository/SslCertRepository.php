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
        $query = $this->getEntityManager()->createQuery("SELECT count(s) FROM App\Entity\SslCert s WHERE s.status != '0'");
        return $query->getSingleScalarResult();
    }
    
    public function getExpiringSSlCerts(int $days = 30): array
    {
        $expiration = new \DateTime();
        $expiration->add(new \DateInterval('P' . $days . 'D'));
        return $this->getEntityManager()
        ->createQuery("SELECT d FROM App\Entity\SslCert d WHERE d.expiryDate <= :expiration AND d.status != '0'")
        ->setParameter('expiration', $expiration)
        ->getResult();
    }
    
    public function getExpiringSslCertCount(int $days = 30): int
    {
        $expiration = new \DateTime();
        $expiration->add(new \DateInterval('P' . $days . 'D'));
        return $this->getEntityManager()
        ->createQuery("SELECT COUNT(d) FROM App\Entity\SslCert d WHERE d.expiryDate <= :expiration AND d.status != '0'")
        ->setParameter('expiration', $expiration)
        ->getSingleScalarResult();
    }
}