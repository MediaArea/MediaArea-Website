<?php

namespace UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;

/**
 * Class AbstractControllerTest.
 */
abstract class UserAbstractControllerTest extends WebTestCase
{
    /**
     * @return Client
     */
    protected function createRegularUserClient()
    {
        return $this->createAuthorizedClient('test@mediaarea.net');
    }

    /**
     * @return Client
     */
    protected function createBetaUserClient()
    {
        return $this->createAuthorizedClient('beta@mediaarea.net');
    }

    /**
     * @param  string $email Email of user to authenticate
     *
     * @return Client
     */
    private function createAuthorizedClient($email)
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $session = $container->get('session');
        $userManager = $container->get('fos_user.user_manager');
        $loginManager = $container->get('fos_user.security.login_manager');
        $firewallName = $container->getParameter('fos_user.firewall_name');

        $user = $userManager->findUserBy(array('email' => $email));
        $loginManager->loginUser($firewallName, $user);

        // save the login token into the session and put it in a cookie
        $container->get('session')->set(
            '_security_'.$firewallName,
            serialize($container->get('security.token_storage')->getToken())
        );

        $container->get('session')->save();
        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));

        return $client;
    }
}
