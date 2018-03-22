<?php

namespace MediaConchOnlineBundle\Lib\Checker;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use MediaConchOnlineBundle\Lib\MediaConch\MediaConchServer;

class CheckerBase
{
    protected $response;
    protected $user;

    public function __construct(MediaConchServer $mc, TokenStorageInterface $tokenStorage)
    {
        $this->mc = $mc;

        $token = $tokenStorage->getToken();
        if (null !== $token && $token->getUser() instanceof UserInterface) {
            $this->user = $token->getUser();
        } else {
            throw new \Exception('Invalid User');
        }
    }

    public function getResponse()
    {
        return $this->response;
    }
}
