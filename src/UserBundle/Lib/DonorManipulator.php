<?php

namespace UserBundle\Lib;

use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use SupportUsBundle\Lib\Individual;

class DonorManipulator
{
    /**
     * User manager.
     *
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * Token generator.
     *
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;

    /**
     * UserManipulator constructor.
     *
     * @param UserManagerInterface    $userManager
     * @param TokenGeneratorInterface $tokenGenerator
     */
    public function __construct(UserManagerInterface $userManager, TokenGeneratorInterface $tokenGenerator)
    {
        $this->userManager = $userManager;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function createOrPromoteDonor($email, $amount, $name)
    {
        $user = $this->userManager->findUserByEmail($email);

        if (!$user) {
            $user = $this->createDonor($email);
            $user->addRole('ROLE_BASIC');
        }

        if (null !== $name) {
            $user->setName($name);
        }

        $individual = new Individual();
        $votes = $individual->amountToVotes($amount, 'EUR');
        $date = $individual->amountToMembership($amount, 'EUR');

        $this->addAmountVotesAndMembershipDateToUser($user, $amount, $votes, $date);
    }

    /**
     * Add a donation to a user.
     *
     * @param User  $user   The user
     * @param float $amount Donation amount
     *
     * @return DonorManipulator
     */
    public function addDonationToUser($user, $amount)
    {
        $this->updateDonor($user, $amount);

        return $this;
    }

    /**
     * Add voting points to a user.
     *
     * @param User $user  The user
     * @param int  $votes Voting points
     *
     * @return DonorManipulator
     */
    public function addVotesToUser($user, $votes)
    {
        $user->setVote($user->getVote() + $votes);

        $this->userManager->updateUser($user);

        return $this;
    }

    /**
     * Set membership end date to user.
     *
     * @param User     $user The user
     * @param DateTime $date Membership end date
     *
     * @return DonorManipulator
     */
    public function setMembershipEndDateToUser($user, $date)
    {
        if ($date > $user->getEndDate()) {
            $user->setEndDate($date);

            $this->userManager->updateUser($user);
        }

        return $this;
    }

    /**
     * Set membership end date to user.
     *
     * @param User     $user   The user
     * @param float    $amount Donation amount
     * @param int      $votes  Voting points
     * @param DateTime $date   Membership end date
     *
     * @return DonorManipulator
     */
    public function addAmountVotesAndMembershipDateToUser($user, $amount, $votes, $date)
    {
        $user->setTotalDonated($user->getTotalDonated() + $amount);
        $user->setVote($user->getVote() + $votes);
        if ($date > $user->getEndDate()) {
            $user->setEndDate($date);
        }

        $this->userManager->updateUser($user);

        return $this;
    }

    protected function createDonor($email)
    {
        $user = $this->userManager->createUser();
        $user->setUsername(uniqid());
        $user->setRealUserName(0);
        $user->setEmail($email);
        $user->setPlainPassword($this->tokenGenerator->generateToken());
        $user->setEnabled(true);

        return $user;
    }

    protected function updateDonor($user, $amount)
    {
        $user->setTotalDonated($user->getTotalDonated() + $amount);

        $this->userManager->updateUser($user);
    }
}
