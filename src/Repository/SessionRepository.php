<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    /**
     * For getting session 
     * 
     * @param int $sessionId
     * 
     * @return array | null
     */
    public function getSession(int $sessionId) {

        return $this->createQueryBuilder("c")
                ->andWhere('c.id = :sessionId')
                ->setParameter("sessionId", $sessionId)
                ->getQuery()
                ->getResult();

        
    }

    /**
     * For removing a session
     * 
     * @param int $session 
     * 
     * @return int
     */
    public function remove(int $sessionId) {
        return $this->createQueryBuilder("c")
                ->delete()
                ->andWhere('c.id = :sessionId')
                ->setParameter("sessionId", $sessionId)
                ->getQuery()
                ->getResult();
    }

    /**
     * For getting many sessions
     * 
     * @param int $start 
     * @param int $offset 
     * @param string $tag 
     * 
     * @return Session[]
     */
    public function getMany(int $start, int $offset, string $tag) {

        $req = $this->createQueryBuilder("c")
            ->setFirstResult($start)
            ->setMaxResults($offset);
        if($tag) {
            $req
            ->andWhere( "c.tag = :tag" )
            ->setParameter("tag", $tag);
        }
            
         return $req   
            ->orderBy("c.uploadedAt", "DESC")
            ->getQuery()
            ->getResult();
    }

    /**
     * For getting a session with notations
     * 
     * @param int $sessionId
     * 
     * @return Session
     */
    public function getSessionWithNotation (int $sessionId) {
        return $this->createQueryBuilder("c")
                ->innerJoin("c.customerFeelings", "customerFeelings")
                ->andWhere('c.id = :sessionId')
                ->setParameter("sessionId", $sessionId)
                ->getQuery()
                ->getResult();
    }

}
