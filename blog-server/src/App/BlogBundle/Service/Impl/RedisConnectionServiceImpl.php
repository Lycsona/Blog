<?php

namespace App\BlogBundle\Service\Impl;

use App\BlogBundle\Service\CacheConnectionService;
use Symfony\Component\Cache\Adapter\RedisAdapter;

/**
 * Class Redis for caching
 */
class RedisConnectionServiceImpl implements CacheConnectionService
{
    public function getInstance()
    {
        return new RedisAdapter(RedisAdapter::createConnection('redis://127.0.0.1:6379'));
    }
}