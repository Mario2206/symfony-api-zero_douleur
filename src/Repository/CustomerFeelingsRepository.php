<?php

namespace App\Repository;

use App\Entity\CustomerFeelings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CustomerFeelings|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerFeelings|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerFeelings[]    findAll()
 * @method CustomerFeelings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerFeelingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerFeelings::class);
    }

    // /**
    //  * @return CustomerFeelings[] Returns an array of CustomerFeelings objects
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
    public function findOneBySomeField($value): ?CustomerFeelings
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
