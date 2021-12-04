<?php

namespace App\Repository;

use App\Entity\FinExpense;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FinExpense|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinExpense|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinExpense[]    findAll()
 * @method FinExpense[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinExpenseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinExpense::class);
    }

    public function findLastNum($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.year = :val')
            ->setParameter('val', $value)
            ->orderBy('i.numExp', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }

    //Expenses by Year
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
