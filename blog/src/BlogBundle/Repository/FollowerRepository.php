<?php

namespace BlogBundle\Repository;

/**
 * FollowerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FollowerRepository extends \Doctrine\ORM\EntityRepository
{
  public function findUserFollow($user, $follower)
    {
        $query =  $this
            ->createQueryBuilder('f')
            ->select('COUNT(f.id)')
            ->where('f.user = :user' )
            ->setParameter(':user', $user)
            ->andWhere('f.follower = :follower' )
            ->setParameter(':follower', $follower)
            ->getQuery();

         return $query->getSingleScalarResult();
    }
}
