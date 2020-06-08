<?php
namespace App\Repository;

use App\Entity\SslCert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\CreationType;
use App\Entity\User;

class SslCertRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SslCert::class);
    }

    public function save(SslCert $cert)
    {
        $cert->setOwner($cert->getAccount()
            ->getOwner())
            ->setSslProvider($cert->getAccount()
            ->getSslProvider());
        $fees = $cert->getSslProvider()->getFee();
        $cert->setFee($fees)->setTotalCost($fees->getInitialFee());
        $cert->setCreationType($this->getEntityManager()
            ->getRepository(CreationType::class)
            ->findOneByName('Manual'));
        $cert->setCreatedBy($this->getEntityManager()
            ->getRepository(User::class)
            ->findOneByUsername('admin'));
        $this->getEntityManager()->persist($cert);
    }

    public function remove(SslCert $cert)
    {
        $this->getEntityManager()->remove($cert);
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

    public function getPendingRenewalCount(): int
    {
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(s) FROM App\Entity\SslCert s WHERE s.status = '3'");
        return $query->getSingleScalarResult();
    }

    public function getPendingRegistrationCount(): int
    {
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(s) FROM App\Entity\SslCert s WHERE s.status = '5'");
        return $query->getSingleScalarResult();
    }

    public function getPendingOtherCount(): int
    {
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(s) FROM App\Entity\SslCert s WHERE s.status = '4'");
        return $query->getSingleScalarResult();
    }
}