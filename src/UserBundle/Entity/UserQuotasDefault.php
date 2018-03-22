<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class UserQuotasDefault
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", inversedBy="quotasDefault")
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
     * @ORM\Column(type="integer")
     */
    protected $urls;

    /**
     * @ORM\Column(type="integer")
     */
    protected $policyChecks;

    /**
     * Set policies.
     *
     * @param int $policies
     *
     * @return UserQuotasDefault
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
     * @return UserQuotasDefault
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
     * Set urls.
     *
     * @param int $urls
     *
     * @return UserQuotasDefault
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
     * Set policyChecks.
     *
     * @param int $policyChecks
     *
     * @return UserQuotasDefault
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
     * Set user.
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return UserQuotasDefault
     */
    public function setUser(\UserBundle\Entity\User $user)
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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
