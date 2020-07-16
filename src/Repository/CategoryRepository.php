<?php
declare(strict_types = 1);
namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $category)
    {
        $this->getEntityManager()->persist($category);
    }

    public function remove(Category $category)
    {
        $this->getEntityManager()->remove($category);
    }
}