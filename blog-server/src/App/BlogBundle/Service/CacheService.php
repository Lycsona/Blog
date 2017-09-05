<?php

namespace App\BlogBundle\Service;

interface CacheService
{

    public function getAllArticles();

    public function getCacheInstance();

    public function saveArticles($data);

    public function deleteArticles();
}