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
            ->select('a.name, a.content, a.createdAt, a.updatedAt, t.name as tag')
            ->from(Article::class, 'a')
            ->innerJoin(Tag::class, 't')
            ->where(':tag MEMBER OF a.tags')
            ->setParameter('tag', $tag);

        return $builder->getQuery()->getResult();
    }
}