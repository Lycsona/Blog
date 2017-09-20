<?php

namespace App\BlogBundle\Service;

interface ArticlesService
{
    public function getArticleById($id);

    public function createArticle($request);

    public function editArticle($request, $id);

    public function deleteArticle($id);

    public function getArticlesByTag($tag);

    public function getArticles($page, $size);

    public function getArticlesFromDB();

    public function getArticlesFromCache();

    public function getArticlesWithPagination($page, $size);

    public function getArticlesWithPaginationFromCache($page, $size);

    public function createCacheArticles();

    public function getException($statusCode, $eventName, $para);
}