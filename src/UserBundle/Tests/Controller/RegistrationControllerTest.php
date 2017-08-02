<?php

namespace UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegisterNotConnected()
    {
        $client = static::createClient();

        $client->request('GET', '/register/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRegisterFormWithoutUsername()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register/');
        $form = $crawler->selectButton('Register')->form();

        $email = 'usertest@mediaarea.net';
        $pass = static::$kernel->getContainer()->get('fos_user.util.token_generator')->generateToken();
        $userManager = static::$kernel->getContainer()->get('fos_user.user_manager');

        $form->setValues(array(
            'fos_user_registration_form[email]' => $email,
            'fos_user_registration_form[plainPassword][first]' => $pass,
            'fos_user_registration_form[plainPassword][second]' => $pass,
        ));
        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/register/confirmed'));

        $user = $userManager->findUserByEmail($email);
        $this->assertNotNull($user);
        $this->assertNotNull($user->getUsername());
        $userManager->deleteUser($user);
    }

    public function testRegisterFormWithUsername()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register/');
        $form = $crawler->selectButton('Register')->form();

        $email = 'usertest@mediaarea.net';
        $username = 'usertest';
        $pass = static::$kernel->getContainer()->get('fos_user.util.token_generator')->generateToken();
        $userManager = static::$kernel->getContainer()->get('fos_user.user_manager');

        $form->setValues(array(
            'fos_user_registration_form[email]' => $email,
            'fos_user_registration_form[plainPassword][first]' => $pass,
            'fos_user_registration_form[plainPassword][second]' => $pass,
            'fos_user_registration_form[username]' => $username,
        ));
        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/register/confirmed'));

        $user = $userManager->findUserByEmail($email);
        $this->assertNotNull($user);
        $this->assertEquals($username, $user->getUsername());
        $userManager->deleteUser($user);
    }
}
