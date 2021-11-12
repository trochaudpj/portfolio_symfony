<?php

namespace App\Repository;

use App\Entity\IntervalDevis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IntervalDevis|null find($id, $lockMode = null, $lockVersion = null)
 * @method IntervalDevis|null findOneBy(array $criteria, array $orderBy = null)
 * @method IntervalDevis[]    findAll()
 * @method IntervalDevis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntervalDevisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IntervalDevis::class);
    }

    // /**
    //  * @return IntervalDevis[] Returns an array of IntervalDevis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IntervalDevis
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
