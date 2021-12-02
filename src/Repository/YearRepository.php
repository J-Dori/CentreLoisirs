<?php

namespace App\Repository;

use App\Entity\Year;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Year|null find($id, $lockMode = null, $lockVersion = null)
 * @method Year|null findOneBy(array $criteria, array $orderBy = null)
 * @method Year[]    findAll()
 * @method Year[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YearRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Year::class);
    }

    // /**
    //  * @return Year[] Returns an array of Year objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('y.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Year
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function activeYear($id)
    {
        $this->createQueryBuilder('y')
            ->update()
            ->set('y.status', 'false')
            ->getQuery()
            ->execute()
        ;

        $this->createQueryBuilder('y')
            ->update()
            ->set('y.status', 'true')
            ->where('y.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute()
        ;
        return;
    }

    public function copyYear($id)
    {
        return $this->createQueryBuilder('y')
            ->select('y.priceMeal', 'y.priceInscription', 'y.numHabilitation')
            ->where('y.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
