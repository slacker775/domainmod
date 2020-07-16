<?php
declare(strict_types=1);
namespace App\Repository;

use App\Entity\User;
use App\Entity\UserSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserSettingRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserSetting::class);
    }

    public function save(UserSetting $setting): void
    {
        $this->getEntityManager()->persist($setting);
    }
    
    public function getSettings(User $user): UserSetting
    {
        return $this->findOneBy(['user' => $user]);
    }
}