<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Contact');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Contact us', $crawler->filter('h1')->text());
        $this->assertEquals('MediaArea', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }

    public function testSendMessageWithoutCompany()
    {
        $this->markTestSkipped('Skipped due to new captcha system');
        $client = static::createClient();

        $crawler = $client->request('GET', '/Contact');

        $form = $crawler->selectButton('Send message')->form();
        $form->setValues([
            'contact[name]' => 'Name',
            'contact[email]' => 'test@mediaarea.net',
            'contact[subject]' => 'Subject',
            'contact[message]' => 'Message',
        ]);
        $client->enableProfiler();
        $crawler = $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/Contact'));

        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        $this->assertEquals(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('Subject', $message->getSubject());
        $this->assertEquals(['test@mediaarea.net' => 'Name'], $message->getFrom());
        $this->assertEquals('info@mediaarea.net', key($message->getTo()));
        $this->assertEquals("Source: web\n\nMessage", $message->getBody());
    }

    public function testSendMessageWithCompany()
    {
        $this->markTestSkipped('Skipped due to new captcha system');
        $client = static::createClient();

        $crawler = $client->request('GET', '/Contact');

        $form = $crawler->selectButton('Send message')->form();
        $form->setValues([
            'contact[name]' => 'Name',
            'contact[email]' => 'test@mediaarea.net',
            'contact[subject]' => 'Subject',
            'contact[message]' => 'Message',
            'contact[company]' => 'My company',
        ]);
        $client->enableProfiler();
        $crawler = $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/Contact'));

        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        $this->assertEquals(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('Subject', $message->getSubject());
        $this->assertEquals(['test@mediaarea.net' => 'Name'], $message->getFrom());
        $this->assertEquals('info@mediaarea.net', key($message->getTo()));
        $this->assertEquals("Source: web\nCompany: My company\n\nMessage", $message->getBody());
    }

    public function testSendMessageWithSponsor()
    {
        $this->markTestSkipped('Skipped due to new captcha system');
        $client = static::createClient();

        $crawler = $client->request('GET', '/Contact?sponsor=Bronze+Sponsor&amount=3000+%E2%82%AC');

        $form = $crawler->selectButton('Send message')->form();
        $values = $form->getValues();
        $this->assertEquals('Request quote for Bronze Sponsor (3000 €)', $values['contact[subject]']);
        $form->setValues([
            'contact[name]' => 'Name',
            'contact[email]' => 'test@mediaarea.net',
        ]);
        $client->enableProfiler();
        $crawler = $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/Contact'));

        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        $this->assertEquals(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('Request quote for Bronze Sponsor (3000 €)', $message->getSubject());
        $this->assertEquals(['test@mediaarea.net' => 'Name'], $message->getFrom());
        $this->assertEquals('info@mediaarea.net', key($message->getTo()));
        $this->assertEquals("Source: web\n\nI'm interested in becoming a MediaArea sponsor.\n\nPlease send me a quote of 3000 € to become a Bronze Sponsor.", $message->getBody());
    }
}
