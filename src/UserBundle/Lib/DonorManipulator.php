<?php

namespace UserBundle\Lib;

use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;

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
        }

        if (null !== $name) {
            $user->setName($name);
        }

        $this->updateDonor($user, $amount);
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
