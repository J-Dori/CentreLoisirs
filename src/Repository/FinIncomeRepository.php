<?php

namespace App\Repository;

use App\Entity\FinIncome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FinIncome|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinIncome|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinIncome[]    findAll()
 * @method FinIncome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinIncomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinIncome::class);
    }

    public function findLastNum($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.year = :val')
            ->setParameter('val', $value)
            ->orderBy('i.numInc', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }

    //Incomes by Year
    public function totalByYear($id)
    {
        return $this->createQueryBuilder('f')
            ->select('SUM(f.amount) AS total')
            ->where('f.year = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
