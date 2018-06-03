<?php

namespace App\BlogBundle\Service\Impl;

use App\BlogBundle\Service\CacheConnectionService;
use App\BlogBundle\Service\CacheService;

class CacheServiceImpl implements CacheService
{
    private $cache;

    public function __construct(CacheConnectionService $cache)
    {
        $this->cache = $cache->getInstance();
    }

    public function hasCache($key)
    {
        return $key->isHit() ? true : false;
    }

    public function getValue($key)
    {
        return $key->get();
    }

    public function getAllArticles()
    {
        $this->deleteArticles();

        return $this->cache->getItem('articles');
    }

    public function getArticlesWithTags($articles)
    {
        foreach ($articles as $article) {
            $tags = $this->getValue($this->cache->getItem('article_tags_' . $article->getId()));

            $article->setTags($tags);
        }
    }

    public function getArticlesTagsKey($articles)
    {
        $tags = [];

        foreach ($articles as $article) {

            $tags[] = 'article_tags_' . $article->getId();
        }

        return $tags;
    }

    public function saveArticles($articles)
    {
        $cachedArticles = $this->getAllArticles();

        $cachedArticles->set($articles);

        $this->cache->save($cachedArticles);

        $this->saveArticleTags($articles);
    }

    public function saveArticleTags($articles)
    {
        foreach ($articles as $article) {

            $articlesTag = $this->cache->getItem('article_tags_' . $article->getId());

            $articlesTag->set($article->getTags()[0]);

            $this->cache->save($articlesTag);
        }
    }

    public function deleteArticles()
    {
        $this->cache->deleteItem('articles');
    }

    public function deleteArticlesTags($articles)
    {
        $articlesTags = $this->getArticlesTagsKey($articles);
        foreach ($articlesTags as $tagKey) {
            $this->cache->deleteItem($tagKey);
        }
    }

    public function deleteAllCache()
    {
        $this->cache->clear();
    }
}