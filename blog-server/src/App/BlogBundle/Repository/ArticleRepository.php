<?php

namespace App\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    /**
     * Get all articles with pagination.
     *
     * @param string $page
     * @param string $size
     * @return array
     */
    public function selectAllArticles($page, $size)
    {
        $builder = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from($this->getEntityName(), 'a');

        $query = $builder->getQuery()
            ->setFirstResult($size * $page)
            ->setMaxResults($size)
            ->getResult();

        $totalPages = ceil($this->getArticlesTotalCount() / $size);
        $firstPage = 1 ? $page == 0 : 0;
        $lastPage = 1 ? $page == $totalPages : 0;

        return [
            'queryResult' => $query,
            'totalPages' => $totalPages,
            'firstPage' => $firstPage,
            'lastPage' => $lastPage
        ];
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

    /**
     * Get total count of articles
     *
     * @return int
     */
    public function getArticlesTotalCount()
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('count(a.id)')
            ->from($this->getEntityName(), 'a');

        return (int)$query->getQuery()->getSingleScalarResult();
    }
}