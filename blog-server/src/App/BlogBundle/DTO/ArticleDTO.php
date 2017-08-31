<?php

namespace App\BlogBundle\DTO;

use App\BlogBundle\Entity\PageViews;
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
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Tag
     */
    private $tags;

    /**
     * @var PageViews
     */
    private $pageViews;

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
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Add tags
     *
     * @param Tag $tags
     * @return Tag
     */
    public function addTag(Tag $tags)
    {
        if (!$this->tags->contains($tags)) {
            $this->tags[] = $tags;
            $tags->addArticle($this);
        }

        return $this;
    }

    /**
     * Remove tags
     *
     * @param Tag $tags
     */
    public function removeTag(Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * @return Tag
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return PageViews
     */
    public function getPageViews()
    {
        return $this->pageViews;
    }

    /**
     * @param PageViews $pageViews
     */
    public function setPageViews($pageViews)
    {
        $this->pageViews = $pageViews;
    }
}
