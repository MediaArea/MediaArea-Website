<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class UserQuotas
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", inversedBy="quotas")
     */
    protected $user;

    /**
     * @ORM\Column(type="integer")
     */
    protected $policies;

    /**
     * @ORM\Column(type="integer")
     */
    protected $uploads;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $uploadsTimestamp;

    /**
     * @ORM\Column(type="integer")
     */
    protected $urls;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $urlsTimestamp;

    /**
     * @ORM\Column(type="integer")
     */
    protected $policyChecks;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $policyChecksTimestamp;

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
     * Set policies.
     *
     * @param int $policies
     *
     * @return QuotasUser
     */
    public function setPolicies($policies)
    {
        $this->policies = $policies;

        return $this;
    }

    /**
     * Get policies.
     *
     * @return int
     */
    public function getPolicies()
    {
        return $this->policies;
    }

    /**
     * Set uploads.
     *
     * @param int $uploads
     *
     * @return QuotasUser
     */
    public function setUploads($uploads)
    {
        $this->uploads = $uploads;

        return $this;
    }

    /**
     * Get uploads.
     *
     * @return int
     */
    public function getUploads()
    {
        return $this->uploads;
    }

    /**
     * Decrease uploads.
     *
     * @param int $uploads
     *
     * @return QuotasUser
     */
    public function decreaseUploads($uploads)
    {
        $this->uploads -= $uploads;

        return $this;
    }

    /**
     * Set urls.
     *
     * @param int $urls
     *
     * @return QuotasUser
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;

        return $this;
    }

    /**
     * Get urls.
     *
     * @return int
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * Decrease urls.
     *
     * @param int $urls
     *
     * @return QuotasUser
     */
    public function decreaseUrls($urls)
    {
        $this->urls -= $urls;

        return $this;
    }

    /**
     * Set user.
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return UserQuotas
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set policyChecks.
     *
     * @param int $policyChecks
     *
     * @return UserQuotas
     */
    public function setPolicyChecks($policyChecks)
    {
        $this->policyChecks = $policyChecks;

        return $this;
    }

    /**
     * Get policyChecks.
     *
     * @return int
     */
    public function getPolicyChecks()
    {
        return $this->policyChecks;
    }

    /**
     * Decrease policyChecks.
     *
     * @param int $policyChecks
     *
     * @return UserQuotas
     */
    public function decreasePolicyChecks($policyChecks)
    {
        $this->policyChecks -= $policyChecks;

        return $this;
    }

    /**
     * Set policyChecksTimestamp.
     *
     * @param \DateTime $policyChecksTimestamp
     *
     * @return UserQuotas
     */
    public function setPolicyChecksTimestamp(\DateTime $policyChecksTimestamp)
    {
        $this->policyChecksTimestamp = $policyChecksTimestamp;

        return $this;
    }

    /**
     * Get policyChecksTimestamp.
     *
     * @return \DateTime
     */
    public function getPolicyChecksTimestamp()
    {
        return $this->policyChecksTimestamp;
    }

    /**
     * Set uploadsTimestamp.
     *
     * @param \DateTime $uploadsTimestamp
     *
     * @return UserQuotas
     */
    public function setUploadsTimestamp($uploadsTimestamp)
    {
        $this->uploadsTimestamp = $uploadsTimestamp;

        return $this;
    }

    /**
     * Get uploadsTimestamp.
     *
     * @return \DateTime
     */
    public function getUploadsTimestamp()
    {
        return $this->uploadsTimestamp;
    }

    /**
     * Set urlsTimestamp.
     *
     * @param \DateTime $urlsTimestamp
     *
     * @return UserQuotas
     */
    public function setUrlsTimestamp($urlsTimestamp)
    {
        $this->urlsTimestamp = $urlsTimestamp;

        return $this;
    }

    /**
     * Get urlsTimestamp.
     *
     * @return \DateTime
     */
    public function getUrlsTimestamp()
    {
        return $this->urlsTimestamp;
    }
}
