<?php

namespace App\BlogBundle\Entity;

use JMS\Serializer\Annotation as JMS;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\BlogBundle\Repository\ArticleRepository")
 * @ORM\Table(name="article")
 *
 * Defines the properties of the Article entity to represent the application Articles.
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @JMS\Groups("list")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @JMS\Groups("list")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     * @JMS\Groups("list")
     */
    private $content;

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

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}
