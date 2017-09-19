<?php

namespace App\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    /**
     * Get all articles with pagination.
     *
     * @return array
     */
    public function selectAllArticles()
    {
        $builder = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from($this->getEntityName(), 'a');

        return $builder->getQuery()->getResult();
    }

    /**
     * Get all articles by tag id with pagination.
     *
     * @param integer $tag
     * @return array
     */
    public function selectAllArticlesByTag($tag)
    {
        $builder = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from($this->getEntityName(), 'a')
            ->leftJoin('a.tags', 't')
            ->where('t.id = :tag')
            ->groupBy('a')
            ->setParameter('tag', $tag);

        return $builder->getQuery()->getResult();
    }
}