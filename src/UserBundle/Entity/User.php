<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 * @SuppressWarnings(PHPMD.TooManyFields)
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
     * @ORM\OneToMany(targetEntity="MediaConchOnlineBundle\Entity\DisplayFile", mappedBy="user", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    protected $display;

    /**
     * @ORM\OneToOne(targetEntity="UserQuotas", mappedBy="user", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    protected $quotas;

    /**
     * @ORM\OneToOne(targetEntity="UserQuotasDefault", mappedBy="user", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    protected $quotasDefault;

    /**
     * @ORM\OneToMany(targetEntity="Settings", mappedBy="user", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    protected $settings;

    /**
     * @ORM\OneToOne(targetEntity="GuestToken", mappedBy="user", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    protected $guestToken;

    /**
     * @ORM\OneToMany(targetEntity="ApiKey", mappedBy="user", cascade={"persist", "remove"}, fetch="EXTRA_LAZY")
     * @Assert\Valid()
     */
    protected $apiKey;

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
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":0})
     */
    protected $totalDonated = 0;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":0})
     */
    protected $vote = 0;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":0})
     */
    protected $displayName = false;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":1})
     */
    protected $realUserName = true;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

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
     * Set totalDonated.
     *
     * @param int $totalDonated
     *
     * @return User
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
     * Is user have donated.
     *
     * @return bool
     */
    public function isDonor()
    {
        return $this->getTotalDonated() > 0;
    }

    /**
     * Set vote.
     *
     * @param int $vote
     *
     * @return User
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
     * Remove vote.
     *
     * @param int $vote
     *
     * @return User
     */
    public function removeVote($vote)
    {
        $this->vote -= $vote;

        return $this;
    }

    /**
     * Set displayName.
     *
     * @param bool $displayName
     *
     * @return User
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
     * Set endDate.
     *
     * @param \DateTime $endDate
     *
     * @return User
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
        return $this->endDate;
    }

    /**
     * Set realUserName.
     *
     * @param bool $realUserName
     *
     * @return User
     */
    public function setRealUserName($realUserName)
    {
        $this->realUserName = $realUserName;

        return $this;
    }

    /**
     * Get realUserName.
     *
     * @return bool
     */
    public function getRealUserName()
    {
        return $this->realUserName;
    }

    /**
     * Get name for display.
     *
     * @return string
     */
    public function getNameForDisplay()
    {
        if (null !== $this->getName() && '' !== $this->getName()) {
            return $this->getName();
        } elseif (1 == $this->getRealUserName()) {
            return $this->getUsername();
        }

        return $this->getEmail();
    }

    /**
     * Add display.
     *
     * @param \MediaConchOnlineBundle\Entity\DisplayFile $display
     *
     * @return User
     */
    public function addDisplay(\MediaConchOnlineBundle\Entity\DisplayFile $display)
    {
        $this->display[] = $display;

        return $this;
    }

    /**
     * Remove display.
     *
     * @param \MediaConchOnlineBundle\Entity\DisplayFile $display
     *
     * @return bool TRUE if this collection contained the specified element, FALSE otherwise
     */
    public function removeDisplay(\MediaConchOnlineBundle\Entity\DisplayFile $display)
    {
        return $this->display->removeElement($display);
    }

    /**
     * Get display.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set quotas.
     *
     * @param \UserBundle\Entity\UserQuotas|null $quotas
     *
     * @return User
     */
    public function setQuotas(\UserBundle\Entity\UserQuotas $quotas = null)
    {
        $this->quotas = $quotas;

        return $this;
    }

    /**
     * Get quotas.
     *
     * @return \UserBundle\Entity\UserQuotas|null
     */
    public function getQuotas()
    {
        return $this->quotas;
    }

    /**
     * Set quotasDefault.
     *
     * @param \UserBundle\Entity\UserQuotasDefault|null $quotasDefault
     *
     * @return User
     */
    public function setQuotasDefault(\UserBundle\Entity\UserQuotasDefault $quotasDefault = null)
    {
        $this->quotasDefault = $quotasDefault;

        return $this;
    }

    /**
     * Get quotasDefault.
     *
     * @return \UserBundle\Entity\UserQuotasDefault|null
     */
    public function getQuotasDefault()
    {
        return $this->quotasDefault;
    }

    /**
     * Add setting.
     *
     * @param \UserBundle\Entity\Settings $setting
     *
     * @return User
     */
    public function addSetting(\UserBundle\Entity\Settings $setting)
    {
        $this->settings[] = $setting;

        return $this;
    }

    /**
     * Remove setting.
     *
     * @param \UserBundle\Entity\Settings $setting
     *
     * @return bool TRUE if this collection contained the specified element, FALSE otherwise
     */
    public function removeSetting(\UserBundle\Entity\Settings $setting)
    {
        return $this->settings->removeElement($setting);
    }

    /**
     * Get settings.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set guestToken.
     *
     * @param \UserBundle\Entity\GuestToken|null $guestToken
     *
     * @return User
     */
    public function setGuestToken(\UserBundle\Entity\GuestToken $guestToken = null)
    {
        $this->guestToken = $guestToken;

        return $this;
    }

    /**
     * Get guestToken.
     *
     * @return \UserBundle\Entity\GuestToken|null
     */
    public function getGuestToken()
    {
        return $this->guestToken;
    }

    /**
     * Add apiKey.
     *
     * @param \UserBundle\Entity\ApiKey $apiKey
     *
     * @return User
     */
    public function addApiKey(\UserBundle\Entity\ApiKey $apiKey)
    {
        $this->apiKey[] = $apiKey;

        return $this;
    }

    /**
     * Remove apiKey.
     *
     * @param \UserBundle\Entity\ApiKey $apiKey
     *
     * @return bool TRUE if this collection contained the specified element, FALSE otherwise
     */
    public function removeApiKey(\UserBundle\Entity\ApiKey $apiKey)
    {
        return $this->apiKey->removeElement($apiKey);
    }

    /**
     * Get apiKey.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
}
