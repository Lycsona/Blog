<?php

namespace App\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\BlogBundle\Repository\PageViewsRepository")
 * @ORM\Table(name="page_views")
 *
 * Defines the properties of the PageViews entity to represent the application PageViews.
 */
class PageViews
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @JMS\Groups("list")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Groups("list")
     */
    private $counter = 0;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * @param integer $counter
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;
    }
}
