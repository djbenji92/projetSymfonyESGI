<?php

namespace BlogBundle\Repository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{
  public function findAllOrderedByDate()
    {
        $query =  $this
            ->createQueryBuilder('a')
            ->orderBy('a.date', 'DESC')
            ->getQuery();

         return $query->getResult();
    }
}
