<?php

namespace App\BlogBundle\Service;

interface PaginatorService
{
    public function paginate($query, $page, $size);

    public function getTotalPage($query, $size);

    public function getFirstPage($page);

    public function getLastPage($query, $page, $size);
}