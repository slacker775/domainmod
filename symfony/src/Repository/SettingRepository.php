<?php
namespace App\Repository;

use App\Entity\Setting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class SettingRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Setting::class);
    }

    public function save(Setting $setting): void
    {
        $this->getEntityManager()->persist($setting);
    }
    
    public function getSettings(): Setting
    {
        return $this->findOneBy([]);
    }
}