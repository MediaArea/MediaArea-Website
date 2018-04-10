<?php

namespace UserBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use UserBundle\Lib\ApiKey\ApiKeyManager;

class ApiKeyUserProvider implements UserProviderInterface
{
    protected $apiKeyManager;

    public function __construct(ApiKeyManager $apiKeyManager)
    {
        $this->apiKeyManager = $apiKeyManager;
    }

    public function getUserForApiKey($apiKey)
    {
        return $this->apiKeyManager->getUserForApiKey($apiKey);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function loadUserByUsername($username)
    {
        return null;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return 'Symfony\Component\Security\Core\User\AdvancedUserInterface' === $class;
    }
}
