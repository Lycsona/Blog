<?php

namespace App\BlogBundle\Service\Impl;

use App\BlogBundle\Service\CacheService;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class CacheServiceImpl implements CacheService
{
    private $connection;

    private static $cache;

    public function __construct()
    {
        $this->connection = RedisAdapter::createConnection('redis://127.0.0.1:6379');
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getCacheInstance()
    {
        if (!self::$cache) {
            self::$cache = new RedisAdapter($this->connection, $namespace = '', $defaultLifetime = 0);
        }
        return self::$cache;
    }

    public function getAllArticles()
    {
        echo('Get articles from Redis.');

        return $this->getCacheInstance()->getItem('articles');
    }

    public function saveArticles($data)
    {
        $cachedArticles = $this->getAllArticles();
        $cachedArticles->set($data);
        self::$cache->save($cachedArticles);
    }

    public function deleteArticles()
    {
    }
}