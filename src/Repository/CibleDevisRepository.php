<?php

namespace App\Repository;

use App\Entity\CibleDevis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CibleDevis|null find($id, $lockMode = null, $lockVersion = null)
 * @method CibleDevis|null findOneBy(array $criteria, array $orderBy = null)
 * @method CibleDevis[]    findAll()
 * @method CibleDevis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CibleDevisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CibleDevis::class);
    }

    // /**
    //  * @return CibleDevis[] Returns an array of CibleDevis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CibleDevis
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
