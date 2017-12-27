<?php

namespace PasteBinBundle\Tests\Controller;

use UserBundle\Tests\Controller\UserAbstractControllerTest;

class DefaultControllerTest extends UserAbstractControllerTest
{
    public function testIndex()
    {
        // User not loggued in (beta period)
        $client = static::createClient();
        $client->request('GET', '/p');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        // User loggued in without ROLE_BETA
        $client = $this->createRegularUserClient();
        $client->request('GET', '/p');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        // User loggued in with ROLE_BETA
        $client = $this->createBetaUserClient();
        $client->request('GET', '/p');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
