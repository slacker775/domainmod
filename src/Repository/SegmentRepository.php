<?php
namespace App\Repository;

use App\Entity\Segment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class SegmentRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Segment::class);
    }

    public function getAllSegments(): array
    {
        $qb = $this->createQueryBuilder('s')
            ->join('s.segmentData', 'sd')
            ->select('s', 'sd')
            ->orderBy('s.name', 'ASC')
            ->addOrderBy('sd.domain', 'ASC');
        return $qb->getQuery()->execute();
    }
}