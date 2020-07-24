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

    public function getCertsWithFilter(array $filters = []): array
    {
        $qb = $this->createQueryBuilder('d')
            ->orderBy('d.name', 'ASC');
        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'keyword':
                    $qb->andWhere('LOWER(d.name) LIKE :keyword')
                        ->setParameter('keyword', '%' . strtolower($value) . '%');
                    break;
                case 'expiringBetween':
                    /* Match '02/15/2004 - 03/31/2007' */
                    $re = '/^(?P<begin>(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d)\s-\s(?P<end>(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d)/';
                    if (preg_match($re, $value, $matches) == 1) {
                        $begin = $matches['begin'];
                        $end = $matches['end'];
                        $qb->andWhere('d.expiryDate BETWEEN :begin AND :end')
                            ->setParameters(['begin' => $begin, 'end' => $end]);
                    }
                    break;
                case 'status':
                    if (is_int($value) == true) {
                        $qb->andWhere('d.status = :status')
                            ->setParameter('status', $value);
                    } else {
                        switch ($value) {
                            case 'All':
                                break;
                            case 'Live':
                                $qb->andWhere("d.status IN ('1','2','3','4','5')");
                                break;
                        }
                    }
                    break;
                default:
                    $qb->andWhere(sprintf('d.%s = :%s', $key, $key))
                        ->setParameter($key, $value);
            }
        }
        return $qb->getQuery()
            ->execute();
    }
}