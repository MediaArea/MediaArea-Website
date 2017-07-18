<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="subscribers")
 */
class Subscriber
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="subscriber")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":0})
     */
    protected $vote = 0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":1})
     */
    protected $displayName = true;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":0})
     */
    protected $totalDonated = 0;

    /**
     * Get Subscriber.
     *
     * @return Subscriber
     */
    public function __toString()
    {
        return $this->user->getUserName();
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
     * Set vote.
     *
     * @param int $vote
     *
     * @return Subscriber
     */
    public function setVote($vote)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote.
     *
     * @return int
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set endDate.
     *
     * @param \DateTime $endDate
     *
     * @return Subscriber
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        if (null === $this->endDate) {
            return new \DateTime();
        }

        return $this->endDate;
    }

    /**
     * Set displayName.
     *
     * @param bool $displayName
     *
     * @return Subscriber
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Get displayName.
     *
     * @return bool
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set totalDonated.
     *
     * @param int $totalDonated
     *
     * @return Subscriber
     */
    public function setTotalDonated($totalDonated)
    {
        $this->totalDonated = $totalDonated;

        return $this;
    }

    /**
     * Get totalDonated.
     *
     * @return int
     */
    public function getTotalDonated()
    {
        return $this->totalDonated;
    }

    /**
     * Set user.
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Subscriber
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
}
