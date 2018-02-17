<?php

namespace App\BlogBundle\Factory;

use App\BlogBundle\DTO\ArticleDTO;
use App\BlogBundle\DTO\TagDTO;
use App\BlogBundle\Entity\Article;
use App\BlogBundle\Entity\Tag;

/**
 * Class ModelFactory.
 */
class ModelFactory
{
    /**
     * Create Article
     *
     * @param ArticleDTO $dto
     * @return Article
     */
    static public function createArticle(ArticleDTO $dto)
    {
        $article = new Article();
        $article->setName($dto->getName());
        $article->setContent($dto->getContent());
        $article->setTags($dto->getTags());
        $article->setImage($dto->getImage());

        return $article;
    }

    /**
     * Create Tag
     *
     * @param TagDTO $dto
     * @return Tag
     */
    static public function createTag(TagDTO $dto)
    {
        $tag = new Tag();
        $tag->setName($dto->getName());

        return $tag;
    }
}