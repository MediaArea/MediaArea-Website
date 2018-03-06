<?php

namespace MediaConchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DocumentationControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testResponse200($url)
    {
        $client = static::createClient();

        $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        return [
            ['/MediaConch/Documentation/Fixity'],
            ['/MediaConch/Documentation/FAQ'],
            ['/MediaConch/Documentation/HowToUse'],
            ['/MediaConch/Documentation/DataFormat'],
            ['/MediaConch/Documentation/Installation'],
        ];
    }
}
