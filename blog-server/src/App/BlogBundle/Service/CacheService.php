<?php

namespace App\BlogBundle\Service;

interface CacheService
{
    public function getAllArticles();

    public function saveArticles($data);

    public function deleteArticles();

    public function hasCache($key);

    public function getValue($key);
}