<?php

namespace UserBundle\Tests\Controller;

class ResettingControllerTest extends UserAbstractControllerTest
{
    public function testReset()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/resetting/request');
        $form = $crawler->selectButton('Reset password')->form();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEmpty(trim($form->get('username')->getValue()));
    }

    public function testResetWithEmailParam()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/resetting/request?email=test@mediaarea.net');
        $form = $crawler->selectButton('Reset password')->form();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('test@mediaarea.net', trim($form->get('username')->getValue()));
    }

    public function testResetConnected()
    {
        $client = $this->createRegularUserClient();

        $client->request('GET', '/resetting/request');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/profile/'));
    }
}
