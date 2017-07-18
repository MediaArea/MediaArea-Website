<?php

namespace UserBundle\Lib;

use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\Email;
use UserBundle\Entity\Subscriber;

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
     * Validator.
     *
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * UserManipulator constructor.
     *
     * @param UserManagerInterface    $userManager
     * @param TokenGeneratorInterface $tokenGenerator
     * @param ValidatorInterface      $validator
     */
    public function __construct(
        UserManagerInterface $userManager,
        TokenGeneratorInterface $tokenGenerator,
        ValidatorInterface $validator
    ) {
        $this->userManager = $userManager;
        $this->tokenGenerator = $tokenGenerator;
        $this->validator = $validator;
    }

    public function createOrPromoteDonor($email, $amount)
    {
        $errors = $this->validator->validate($email, new Email());
        if ($errors->count()) {
            throw new \Exception('Email is not valid');
        }

        $user = $this->userManager->findUserByEmail($email);

        if (!$user) {
            $user = $this->createDonor($email);
        }

        $this->updateDonor($user, $amount);
    }

    protected function createDonor($email)
    {
        $user = $this->userManager->createUser();
        $user->setUsername($email);
        $user->setEmail($email);
        $user->setPlainPassword($this->tokenGenerator->generateToken());
        $user->setEnabled(true);

        return $user;
    }

    protected function updateDonor($user, $amount)
    {
        $user->setDonor(true);

        if (!$subscriber = $user->getSubscriber()) {
            $subscriber = new Subscriber();
            $subscriber->setUser($user);
        }

        $subscriber->setTotalDonated($subscriber->getTotalDonated() + $amount);
        $user->setSubscriber($subscriber);
        $this->userManager->updateUser($user);
    }
}
