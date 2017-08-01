<?php

namespace UserBundle\Tests\Controller;

class ProfileControllerTest extends UserAbstractControllerTest
{
    public function testProfileNotConnected()
    {
        $client = static::createClient();

        $client->request('GET', '/profile/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/login'));
    }

    public function testProfileConnected()
    {
        $client = $this->createAuthorizedClient();

        $crawler = $client->request('GET', '/profile/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            'Email: test@mediaarea.net',
            trim($crawler->filter('.fos_user_user_show p')->text())
        );
    }

    public function testProfileEdit()
    {
        $client = $this->createAuthorizedClient();

        $crawler = $client->request('GET', '/profile/edit');
        $form = $crawler->selectButton('Update')->form();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            'test@mediaarea.net',
            trim($form->get('fos_user_profile_form[email]')->getValue())
        );
    }
}
