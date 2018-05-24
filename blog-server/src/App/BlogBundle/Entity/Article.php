<?php

namespace App\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @ORM\Column(type="string", length=3000)
     * @JMS\Groups("list")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=70, nullable = true)
     * @JMS\Groups("list")
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable = true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="articles", cascade={"persist"}, fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="article_tag",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     */
    private $tags;

    /**
     * @ORM\OneToOne(targetEntity="PageViews", cascade={"all"})
     * @ORM\JoinColumn(name="page_views_id", referencedColumnName="id")
     *
     */
    private $pageViews;

    public function __construct()
    {
        $this->pageViews = new PageViews();
        $this->tags = new ArrayCollection();
        $this->createdAt = date_create('now');
        $this->updatedAt = date_create('now');
    }

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
    public function setCreatedAt(\DateTime $createdAt)
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
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Add tag
     *
     * @param Tag $tag
     * @return Article
     */
    public function addTag(Tag $tag)
    {
        if ($this->tags->contains($tag)) {
            return $this; // or just return;
        }

        // This prevents adding duplicates of new tags that aren't in the
        // DB already.
        $tagKey = $tag->getName() ?? $tag->getHash();
        $this->tags[$tagKey] = $tag;
    }

    /**
     * Remove tag
     *
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
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
}
