<?php

namespace App\BlogBundle\Factory;

use App\BlogBundle\DTO\ArticleDTO;
use App\BlogBundle\Entity\Article;

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
        $Article = new Article();
        $Article->setName($dto->getName());
        $Article->setContent($dto->getContent());

        return $Article;
    }
}