<?php

namespace App\Repository;

use App\Entity\Inscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscription[]    findAll()
 * @method Inscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscription::class);
    }


    public function findLastNumInscription($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.year = :val')
            ->setParameter('val', $value)
            ->orderBy('i.numInsc', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }

    //Update Values after New Inscription: qttMeal, priceInsc, TotalInsc
    public function updatePrices($id, $weekPrice, $qttMeal, $priceInsc, $totalInsc)
    {
        return $this->createQueryBuilder('i')
                ->update()
                ->set('i.totalWeek', $weekPrice)
                ->set('i.qttMeal', $qttMeal)
                ->set('i.priceInsc', $priceInsc)
                ->set('i.totalInsc', $totalInsc)
                ->where('i.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->execute();
        ;
    }

    //DASHBOARD
    //Total excepted to be receive/paid by all registered Inscriptions, by Year
    public function getTotalPaymentExceptedByYear($id)
    {
        return $this->createQueryBuilder('i')
            ->select('SUM(i.totalInsc) AS total')
            ->where('i.year = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    //Totals by all registered Inscriptions, by Year
    public function getTotalByColumnByYear($id)
    {
        return $this->createQueryBuilder('i')
            ->select('COUNT(i.id) AS totalInscription, 
                        SUM(i.totalWeek) AS totalWeek, 
                        SUM(i.qttMeal) AS totalMeal, 
                        SUM(i.priceInsc) AS totalPriceInsc')
            ->where('i.year = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult()
        ;
    }

}
