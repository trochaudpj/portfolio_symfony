<?php

namespace App\Repository;

use App\Entity\TechnoDevis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TechnoDevis|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechnoDevis|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechnoDevis[]    findAll()
 * @method TechnoDevis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnoDevisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnoDevis::class);
    }

    // /**
    //  * @return TechnoDevis[] Returns an array of TechnoDevis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TechnoDevis
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
