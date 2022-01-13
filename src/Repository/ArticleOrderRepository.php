<?php

namespace App\Repository;

use App\Entity\ArticleOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArticleOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleOrder[]    findAll()
 * @method ArticleOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleOrder::class);
    }

    // /**
    //  * @return ArticleOrder[] Returns an array of ArticleOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArticleOrder
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
