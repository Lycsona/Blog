<?php

namespace App\BlogBundle\Service\Impl;

use App\BlogBundle\Entity\Article;
use App\BlogBundle\Service\ArticlesService;
use App\BlogBundle\Service\CacheService;
use App\BlogBundle\Service\PaginatorService;
use Doctrine\ORM\EntityManager;

class ArticleServiceImpl implements ArticlesService
{
    private $em;

    private $pagination;

    private $cache;

    public function __construct(EntityManager $em, PaginatorService $pagination, CacheService $cache)
    {
        $this->em = $em;
        $this->pagination = $pagination;
        $this->cache = $cache;
    }

    public function getArticleById()
    {
    }

    public function createArticle()
    {
    }

    public function editArticle()
    {
    }

    public function deleteArticle()
    {
    }

    public function getArticlesByTag()
    {
    }

    public function getArticles()
    {
        return $this->em->getRepository(Article::class)->selectAllArticles();
    }

    public function getArticlesFromCache()
    {
        $articles = null;

        $cachedArticles = $this->cache->getAllArticles();
        if ($this->cache->hasCache($cachedArticles)) {
            $articles = $this->cache->getValue($cachedArticles);
        }

        return $articles;
    }

    public function getArticlesWithPagination($page, $size)
    {
        return $this->pagination->paginate($this->getArticles(), $page, $size);
    }

    public function getArticlesWithPaginationFromCache($page, $size)
    {
        return $this->pagination->paginate($this->getArticlesFromCache(), $page, $size);
    }

    public function saveCacheArticles()
    {
        $this->cache->saveArticles($this->getArticles());
    }
}