<?php

namespace App\BlogBundle\DTO;

use App\BlogBundle\Entity\Tag;

/**
 * DTO for Article object.
 */
class ArticleDTO
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $content;

    /**
     * @var Tag
     */
    private $tag;

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

    /**
     * @return Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param Tag $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }
}
