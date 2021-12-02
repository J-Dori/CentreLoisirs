<?php

namespace App\Repository;

use App\Entity\InscriptionDetail;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InscriptionDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method InscriptionDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method InscriptionDetail[]    findAll()
 * @method InscriptionDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InscriptionDetail::class);
    }

    //Results to NEW/EDIT Inscriptions
    public function getTotalChildren($id)
    {
        return $this->createQueryBuilder('det')
            ->select('COUNT(DISTINCT det.children) AS total')
            ->andWhere('det.inscription = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getTotalWeek($id)
    {
        return $this->createQueryBuilder('det')
            ->select('COUNT(det.week) AS total')
            ->andWhere('det.inscription = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getTotalMeal($id)
    {
        return $this->createQueryBuilder('det')
            ->select('COUNT(det.withMeal) AS total')
            ->andWhere('det.inscription = :id')
            ->andWhere('det.withMeal = true')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    //set YearId to all InscriptionDetails (form CollectionType) on NEW inscription
    public function setYearNewInscription($inscID, $yearID)
    {
        return $this->createQueryBuilder('det')
                ->update()
                ->set('det.year', $yearID)
                ->where('det.inscription = :id')
                ->setParameter('id', $inscID)
                ->getQuery()
                ->execute();
        ;
    }
    //END : Results to NEW/EDIT Inscriptions

    //********************************** DASHBOARD **********************************/
    //count nº of Children By Week / from YEAR
    public function dashboard_countChildren($year)
    {
        return $this->createQueryBuilder('det')
            ->select('COUNT(DISTINCT det.children) AS total')
            ->andWhere('det.year = :val')
            ->groupBy('det.week')
            ->setParameter('val', $year)
            ->getQuery()
            ->getResult()
        ;
    }

}
