<?php

namespace App\BlogBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class ApiExceptionEvent extends Event
{
    private $id;

    private $statusCode;

    public function __construct($id, $statusCode)
    {
        $this->id = $id;
        $this->statusCode = $statusCode;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}