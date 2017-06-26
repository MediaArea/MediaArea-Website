<?php

namespace AVIMetaEditBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StandardsControllerTest extends WebTestCase
{
    public function testListinfo()
    {
        $client = static::createClient();

        $client->request('GET', '/AVIMetaEdit/listinfo');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testImit()
    {
        $client = static::createClient();

        $client->request('GET', '/AVIMetaEdit/imit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testXmlChunks()
    {
        $client = static::createClient();

        $client->request('GET', '/AVIMetaEdit/xml_chunks');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
