<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\User;

class UserRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
    }

    public function remove(User $user): void
    {
        $this->getEntityManager()->remove($user);
    }

    public function findByName(string $username): User
    {
        return $this->createQueryBuilder('u')
            ->where('u.username=:name')
            ->setParameter('name', $username)
            ->getQuery()
            ->getSingleResult();
    }
}