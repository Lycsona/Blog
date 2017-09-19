<?php

namespace App\BlogBundle\Service\Impl;

use App\BlogBundle\Service\PaginatorService;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAware;

class PaginatorServiceImpl extends PaginatorAware implements PaginatorService
{
    /**
     *
     * @param mixed $query
     * @param int $page
     * @param int $size
     *
     * @return array
     */
    public function paginate($query, $page, $size)
    {
        $paginator = $this->getPaginator();
        $result = $paginator->paginate($query, $page + 1, $size, ['distinct' => false]);

        return [
            'result' => $result,
            'totalPages' => $this->getTotalPage($query, $size),
            'firstPage' => $this->getFirstPage($page),
            'lastPage' => $this->getLastPage($query, $page, $size)
        ];
    }

    public function getTotalPage($query, $size)
    {
        return ceil(count($query) / $size);
    }

    public function getFirstPage($page)
    {
        return 1 ? $page == 0 : 0;
    }

    public function getLastPage($query, $page, $size)
    {
        return 1 ? $page == $this->getTotalPage($query, $size) : 0;
    }
}