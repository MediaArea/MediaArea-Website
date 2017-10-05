<?php

namespace SupportUsBundle\Tests\Controller;

use UserBundle\Tests\Controller\UserAbstractControllerTest;

class DefaultControllerTest extends UserAbstractControllerTest
{
    public function testAbout()
    {
        // User not loggued in
        $client = static::createClient();
        $client->request('GET', '/SupportUs');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        // User loggued in without ROLE_BETA
        $client = $this->createRegularUserClient();
        $client->request('GET', '/SupportUs');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

        // User loggued in with ROLE_BETA
        $client = $this->createBetaUserClient();
        $crawler = $client->request('GET', '/SupportUs');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Support Us!', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }

    public function testIndividual()
    {
        $client = $this->createBetaUserClient();
        $client->request('GET', '/SupportUs/Individual');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCorporate()
    {
        $client = $this->createBetaUserClient();
        $client->request('GET', '/SupportUs/Corporate');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFaq()
    {
        $client = $this->createBetaUserClient();
        $client->request('GET', '/SupportUs/FAQ');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSponsorsList()
    {
        $client = $this->createBetaUserClient();
        $client->request('GET', '/SupportUs/Sponsors');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSupportersList()
    {
        $client = $this->createBetaUserClient();
        $client->request('GET', '/SupportUs/Supporters');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
