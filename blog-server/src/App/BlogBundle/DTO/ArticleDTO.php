<?php

namespace App\BlogBundle\DTO;

use App\BlogBundle\Entity\PageViews;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * DTO for Article object.
 */
class ArticleDTO
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $name;

    /**
     * @var string
     * @Assert\Length(max=3000)
     */
    private $content;

    /**
     * @var string
     */
    private $image;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var ArrayCollection $tags
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
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

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @param array $data
     * @return ArticleDTO
     */
    public function build(array $data)
    {
        $this->setName($data['name']);
        $this->setContent($data['content']);
        $this->setImage($data['image']);
        $this->setTags($data['tags']);

        return $this;
    }
}
