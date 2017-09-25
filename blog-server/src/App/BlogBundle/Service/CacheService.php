<?php

namespace App\BlogBundle\Service;

interface CacheService
{
    public function getAllArticles();

    public function getArticlesWithTags($articles);

    public function getArticlesTagsKey($articles);

    public function saveArticles($data);

    public function saveArticleTags($data);

    public function hasCache($key);

    public function getValue($key);

    public function deleteArticles();

    public function deleteArticlesTags($articles);}