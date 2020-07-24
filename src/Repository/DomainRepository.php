<?php

namespace App\Repository;

use App\Entity\Domain;
use App\Entity\Fee;
use App\Entity\Registrar;
use App\Entity\SegmentData;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr;

class DomainRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Domain::class);
    }

    public function remove(Domain $domain): void
    {
        $this->getEntityManager()
            ->remove($domain);
    }

    public function getActiveDomainCount(): int
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT count(d) FROM App\Entity\Domain d WHERE d.status NOT IN ('0','10')");
        return $query->getSingleScalarResult();
    }

    public function getDomainCountByStatus(int $status): int
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT count(d) FROM App\Entity\Domain d WHERE d.status = :status")
            ->setParameter('status', $status);
        return $query->getSingleScalarResult();
    }

    public function getExpiringDomains(int $days = 30): array
    {
        $expiration = new DateTime();
        $expiration->add(new DateInterval('P' . $days . 'D'));
        return $this->getEntityManager()
            ->createQuery("SELECT d FROM App\Entity\Domain d WHERE d.expiryDate <= :expiration AND d.status NOT IN ('0','10')")
            ->setParameter('expiration', $expiration)
            ->getResult();
    }

    public function getExpiringDomainCount(int $days = 30): int
    {
        $expiration = new DateTime();
        $expiration->add(new DateInterval('P' . $days . 'D'));
        return $this->getEntityManager()
            ->createQuery("SELECT COUNT(d) FROM App\Entity\Domain d WHERE d.expiryDate <= :expiration AND d.status NOT IN ('0','10')")
            ->setParameter('expiration', $expiration)
            ->getSingleScalarResult();
    }

    public function getTldsWithoutFeeAssignments(Registrar $registrar): array
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT d.tld FROM App\Entity\Domain d WHERE d.registrar=:registrar AND d.fee IS NULL GROUP BY d.tld ORDER BY d.tld");
        return $query->execute([
            'registrar' => $registrar
        ], AbstractQuery::HYDRATE_ARRAY);
    }

    public function updateDomainFees(Domain $domain): void
    {
        $fees = $this->getEntityManager()
            ->getRepository(Fee::class)
            ->findOneBy([
                'registrar' => $domain->getRegistrar(),
                'tld'       => $domain->getTld()
            ]);
        if ($fees !== null) {
            $totalCost = $fees->getRenewalFee() + $fees->getMiscFee();
            if ($domain->isPrivacy() === true) {
                $totalCost += $fees->getPrivacyFee();
            }
            $domain->setFee($fees)
                ->setFeeFixed(true)
                ->setTotalCost($totalCost);
        } else {
            $domain->setFee(null)
                ->setFeeFixed(false)
                ->setTotalCost(0);
        }
        $this->save($domain);
    }

    public function save(Domain $domain): void
    {
        $this->getEntityManager()
            ->persist($domain);
    }

    public function getDomainsWithFilter(array $filters = []): array
    {
        $qb = $this->createQueryBuilder('d')
            ->orderBy('d.name', 'ASC');
        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'count':
                    $qb->setMaxResults($value);
                    break;
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
                case 'segment':
                    $qb->join(SegmentData::class, 's', Expr\Join::WITH, 's.domain=d.name');
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

    public function getDomainTotalCost(): float
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT SUM(d.total_cost * cc.conversion) FROM App\Entity\Domain d JOIN d.category");

        return $query->getSingleScalarResult();
    }
}