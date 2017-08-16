<?php

namespace App\BlogBundle\DTO;

/**
 * DTO for Tag object.
 */
class TagDTO
{
    /**
     * @var string
     */
    private $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
