<?php

namespace MediaConchOnlineBundle\Tests\Controller;

class CheckerControllerTest extends AbstractAuthControllerTest
{
    public function testChecker()
    {
        $crawler = $this->client->request('GET', '/MediaConchOnline/checker');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->filter('h1:contains("Check files")'));
    }
}
