<?php

namespace BWFMetaEditBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StandardsControllerTest extends WebTestCase
{
    public function testBext()
    {
        $client = static::createClient();

        $client->request('GET', '/BWFMetaEdit/bext');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testListinfo()
    {
        $client = static::createClient();

        $client->request('GET', '/BWFMetaEdit/listinfo');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testXmlChunks()
    {
        $client = static::createClient();

        $client->request('GET', '/BWFMetaEdit/xml_chunks');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
