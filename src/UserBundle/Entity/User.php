<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     maxMessage="Your name is too short (min 2).",
     *     maxMessage="Your name is too long (max 255).",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $professional;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     maxMessage="The company name is too short (min 2).",
     *     maxMessage="The company name is too long (max 255).",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $companyName;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":1})
     */
    protected $newsletter = true;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    protected $country;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $language;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":0})
     */
    protected $donor = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="Subscriber", mappedBy="user", cascade={"persist"})
     */
    private $subscriber;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Gets triggered only on insert.
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set professional.
     *
     * @param bool $professional
     *
     * @return User
     */
    public function setProfessional($professional)
    {
        $this->professional = $professional;

        return $this;
    }

    /**
     * Get professional.
     *
     * @return bool
     */
    public function getProfessional()
    {
        return $this->professional;
    }

    /**
     * Set companyName.
     *
     * @param string $companyName
     *
     * @return User
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName.
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set newsletter.
     *
     * @param bool $newsletter
     *
     * @return User
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter.
     *
     * @return bool
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Set country.
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set language.
     *
     * @param string $language
     *
     * @return User
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set donor.
     *
     * @param bool $donor
     *
     * @return User
     */
    public function setDonor($donor)
    {
        $this->donor = $donor;

        return $this;
    }

    /**
     * Get donor.
     *
     * @return bool
     */
    public function getDonor()
    {
        return $this->donor;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return User
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
     * Set subscriber.
     *
     * @param \UserBundle\Entity\Subscriber $subscriber
     *
     * @return User
     */
    public function setSubscriber(\UserBundle\Entity\Subscriber $subscriber = null)
    {
        $this->subscriber = $subscriber;

        return $this;
    }

    /**
     * Get subscriber.
     *
     * @return \UserBundle\Entity\Subscriber
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }
}
