<?php
namespace App\Repository;

use App\Entity\SslProvider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\CreationType;
use App\Entity\User;

class SslProviderRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SslProvider::class);
    }

    public function save(SslProvider $provider)
    {
        $provider->setCreationType($this->getEntityManager()
            ->getRepository(CreationType::class)
            ->findOneByName('Manual'));
        $provider->setCreatedBy($this->getEntityManager()
            ->getRepository(User::class)
            ->findOneByUsername('admin'));
        $this->getEntityManager()->persist($provider);
    }

    public function remove(SslProvider $provider)
    {
        $this->getEntityManager()->remove($provider);
    }

}