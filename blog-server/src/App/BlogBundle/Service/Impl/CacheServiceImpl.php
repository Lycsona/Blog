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
        return $this->cache->getItem('articles');
    }

    public function saveArticles($articles)
    {
        $cachedArticles = $this->getAllArticles();

        $cachedArticles->set($articles);

        $this->cache->save($cachedArticles);
    }

    public function deleteArticles()
    {
        $this->cache->deleteItem('articles');
    }
}