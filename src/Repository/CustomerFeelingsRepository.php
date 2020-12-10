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


    public function getCustomerFeelingsFromOneSession(int $sessionId) {
        return $this->createQueryBuilder("c")
                ->andWhere('c.sessionId = :sessionId')
                ->setParameter("sessionId", $sessionId)
                ->getQuery()
                ->getResult();
    }

    public function removeManyRowAccordingToSession(int $sessionId) {
        return $this->createQueryBuilder("c")
                ->delete()
                ->andWhere("c.sessionId = :sessionId")
                ->setParameter("sessionId", $sessionId)
                ->getQuery()
                ->getResult();
    }
    
}
