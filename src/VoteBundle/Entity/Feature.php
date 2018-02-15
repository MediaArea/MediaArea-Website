<?php

namespace VoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Parsedown;
use VoteBundle\Model\FeatureInterface;

/**
 * @ORM\Entity(repositoryClass="VoteBundle\Repository\FeatureRepository")
 * @ORM\Table(name="vote_features", indexes={@ORM\Index(name="status_idx", columns={"status"})})
 */
class Feature implements FeatureInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @Gedmo\Slug(fields={"title"}, style="camel")
     * @ORM\Column(length=255)
     */
    protected $slug;

    /**
     * @ORM\Column(type="text", length=65535)
     */
    protected $description;

    /**
     * @ORM\Column(type="integer", options={"default":0, "unsigned":true})
     */
    protected $votesTarget = 0;

    /**
     * @ORM\Column(type="integer", options={"default":0, "unsigned":true})
     */
    protected $votesCountCache = 0;

    /**
     * @ORM\Column(type="smallint", options={"default":0, "unsigned":true})
     */
    protected $status = 0;

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return Feature
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Feature
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Feature
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get description as HTML (from markdown).
     *
     * @return string
     */
    public function getHtmlDescription()
    {
        $mdParser = new Parsedown();

        return $mdParser->text($this->description);
    }

    /**
     * Set votesTarget.
     *
     * @param int $votesTarget
     *
     * @return Feature
     */
    public function setVotesTarget($votesTarget)
    {
        $this->votesTarget = $votesTarget;

        return $this;
    }

    /**
     * Get votesTarget.
     *
     * @return int
     */
    public function getVotesTarget()
    {
        return $this->votesTarget;
    }

    /**
     * Set votesCountCache.
     *
     * @param int $votesCountCache
     *
     * @return Feature
     */
    public function setVotesCountCache($votesCountCache)
    {
        $this->votesCountCache = $votesCountCache;

        return $this;
    }

    /**
     * Get votesCountCache.
     *
     * @return int
     */
    public function getVotesCountCache()
    {
        return $this->votesCountCache;
    }

    /**
     * Add votesCountCache.
     *
     * @param int $votesCountCache
     *
     * @return Feature
     */
    public function addVotesCountCache($votesCountCache)
    {
        $this->votesCountCache += $votesCountCache;

        return $this;
    }

    /**
     * Set status.
     *
     * @param int $status
     *
     * @return Feature
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get completion ratio.
     *
     * @return float
     */
    public function getCompletionRatio()
    {
        if (0 == $this->votesCountCache) {
            return 0;
        }

        return $this->votesCountCache / $this->votesTarget * 100;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Feature
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
