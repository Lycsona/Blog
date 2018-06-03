<?php

namespace App\BlogBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class IncorrectLoginEvent extends Event
{
    private $attempts;

    /**
     * IncorrectLoginEvent constructor.
     *
     * @param string $num
     */
    public function __construct($num)
    {
        $this->attempts = $num;
    }

    /**
     * @return string
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * @param string $num
     */
    public function setAttempts($num)
    {
        $this->attempts = $num;
    }
}