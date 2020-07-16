<?php
declare(strict_types = 1);
namespace App\Repository;

use App\Entity\SslAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class SslAccountRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SslAccount::class);
    }

    public function save(SslAccount $account)
    {
        $this->getEntityManager()->persist($account);
    }

    public function remove(SslAccount $account)
    {
        $this->getEntityManager()->remove($account);
    }
}