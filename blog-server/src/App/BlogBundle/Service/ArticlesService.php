<?php

namespace App\BlogBundle\Service;

interface ArticlesService
{
    public function getArticleById();

    public function createArticle();

    public function editArticle();

    public function deleteArticle();

    public function getArticlesByTag();

    public function getArticles();

    public function getArticlesFromCache();

    public function getArticlesWithPagination($page, $size);

    public function getArticlesWithPaginationFromCache($page, $size);

    public function saveCacheArticles();
}