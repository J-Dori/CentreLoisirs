<?php

namespace App\Repository;

use App\Entity\FinCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FinCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinCategory[]    findAll()
 * @method FinCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinCategory::class);
    }

    // /**
    //  * @return FinCategory[] Returns an array of FinCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FinCategory
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
