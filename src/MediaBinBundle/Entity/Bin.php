<?php

namespace MediaBinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use MediaBinBundle\Model\BinInterface;

/**
 * @ORM\Entity(repositoryClass="MediaBinBundle\Repository\BinRepository")
 * @ORM\Table(name="bin", indexes={@ORM\Index(name="visibility_idx", columns={"visibility"})})
 */
class Bin implements BinInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(type="string", length=8, unique=true)
     */
    protected $hash;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;

    /**
     * @ORM\Column(type="smallint", options={"default":0, "unsigned":true})
     */
    protected $format = 0;

    /**
     * @ORM\Column(type="smallint", options={"default":0, "unsigned":true})
     */
    protected $anonymize = 0;

    /**
     * @ORM\Column(type="smallint", options={"default":0, "unsigned":true})
     */
    protected $visibility = 0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $expireAt;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

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
     * Set hash.
     *
     * @param string $hash
     *
     * @return Bin
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Bin
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
     * Get title for listing (add expired info).
     *
     * @return string
     */
    public function getTitleListing($default)
    {
        $title = '' != $this->title ? $this->title : $default;

        if ($this->getExpireAt() && $this->getExpireAt() < new \DateTime()) {
            return $title.' (expired)';
        }

        return $title;
    }

    /**
     * Set format.
     *
     * @param int $format
     *
     * @return Bin
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format.
     *
     * @return int
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set anonymize.
     *
     * @param int $anonymize
     *
     * @return Bin
     */
    public function setAnonymize($anonymize)
    {
        $this->anonymize = $anonymize;

        return $this;
    }

    /**
     * Get anonymize.
     *
     * @return int
     */
    public function getAnonymize()
    {
        return $this->anonymize;
    }

    /**
     * Set visibility.
     *
     * @param int $visibility
     *
     * @return Bin
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility.
     *
     * @return int
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set expireAt.
     *
     * @param \DateTime|null $expireAt
     *
     * @return Bin
     */
    public function setExpireAt($expireAt = null)
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    /**
     * Get expireAt.
     *
     * @return \DateTime|null
     */
    public function getExpireAt()
    {
        return $this->expireAt;
    }

    /**
     * Check if bin is expired.
     *
     * @return bool
     */
    public function hasExpired()
    {
        if (null !== $this->expireAt && new \DateTime() > $this->expireAt) {
            return true;
        }

        return false;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Bin
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user.
     *
     * @param \UserBundle\Entity\User|null $user
     *
     * @return Bin
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \UserBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }
}
