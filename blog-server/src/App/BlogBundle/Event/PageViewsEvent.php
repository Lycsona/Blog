<?php

namespace App\BlogBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class PageViewsEvent extends Event
{
    private $pageViewsId;

    /**
     * PageViewsEvent constructor.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->pageViewsId = $id;
    }

    /**
     * @return string
     */
    public function getPageViewsId()
    {
        return $this->pageViewsId;
    }

    /**
     * @param string $id
     */
    public function setPageViewsId($id)
    {
        $this->pageViewsId = $id;
    }
}