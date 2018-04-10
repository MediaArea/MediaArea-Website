<?php

namespace MediaConchOnlineBundle\Tests\Controller;

class DisplayControllerTest extends AbstractAuthControllerTest
{
    public function testDisplay()
    {
        $crawler = $this->client->request('GET', '/MediaConchOnline/display/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->filter('h1:contains("Display")'));
    }
}
