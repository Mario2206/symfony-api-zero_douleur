<?php

namespace App\Repository;

use App\Entity\ContentVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContentVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContentVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContentVideo[]    findAll()
 * @method ContentVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContentVideo::class);
    }

    // /**
    //  * @return ContentVideo[] Returns an array of ContentVideo objects
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
    public function findOneBySomeField($value): ?ContentVideo
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
