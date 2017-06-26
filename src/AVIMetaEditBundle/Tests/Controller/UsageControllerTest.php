<?php

namespace AVIMetaEditBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsageControllerTest extends WebTestCase
{
    public function testPreferences()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AVIMetaEdit/options');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMd5()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AVIMetaEdit/md5');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testValidationsRules()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AVIMetaEdit/validation_rules_help');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testWorkflows()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AVIMetaEdit/workflows');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
