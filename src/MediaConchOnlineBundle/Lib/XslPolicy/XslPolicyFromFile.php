<?php

namespace MediaConchOnlineBundle\Lib\XslPolicy;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use MediaConchOnlineBundle\Lib\MediaConch\MediaConchServer;

class XslPolicyFromFile
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

    public function getPolicy($id)
    {
        $this->response = $this->mc->policyFromFile($this->user->getId(), $id);
    }

    public function getCreatedId()
    {
        return $this->response->getPolicyId();
    }
}
