<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        $this->getEntityManager()
            ->persist($user);
    }

    public function remove(User $user): void
    {
        $this->getEntityManager()
            ->remove($user);
    }

    public function findByName(string $username): User
    {
        return $this->createQueryBuilder('u')
            ->where('u.username=:name')
            ->setParameter('name', $username)
            ->getQuery()
            ->getSingleResult();
    }

    public function getUsersForExpirationEmails(): array
    {
        return $this->createQueryBuilder('u')
            ->join('u.settings', 's')
            ->andWhere('s.expirationEmails = true')
            ->getQuery()
            ->execute();
    }
}