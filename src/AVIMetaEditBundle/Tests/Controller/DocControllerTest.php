<?php

namespace AVIMetaEditBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DocControllerTest extends WebTestCase
{
    public function testTech()
    {
        $client = static::createClient();

        $client->request('GET', '/AVIMetaEdit/tech_view_help');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCore()
    {
        $client = static::createClient();

        $client->request('GET', '/AVIMetaEdit/core_doc_help');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testTrace()
    {
        $client = static::createClient();

        $client->request('GET', '/AVIMetaEdit/trace');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testErrors()
    {
        $client = static::createClient();

        $client->request('GET', '/AVIMetaEdit/errors');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
