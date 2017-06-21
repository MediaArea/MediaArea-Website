<?php

namespace BWFMetaEditBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsageControllerTest extends WebTestCase
{
    public function testPreferences()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/BWFMetaEdit/options');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMd5()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/BWFMetaEdit/md5');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testValidationsRules()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/BWFMetaEdit/validation_rules_help');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testWorkflows()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/BWFMetaEdit/workflows');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
