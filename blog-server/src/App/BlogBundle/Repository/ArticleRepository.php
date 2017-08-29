<?php

namespace App\BlogBundle\Repository;

use App\BlogBundle\Entity\Article;
use App\BlogBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    /**
     * @param $tag
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