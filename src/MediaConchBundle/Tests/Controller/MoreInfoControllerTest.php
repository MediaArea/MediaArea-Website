<?php

namespace MediaConchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoreInfoControllerTest extends WebTestCase
{
    protected function setUp()
    {
        // The analysis of the reports emits notices and warnings, ignored in production
        $this->iniSet('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);
    }

    public function testReportTextIsEscaped()
    {
        $report = '{"media":{"track":[{"Format":"MXF","extra":{"ConformanceErrors":'
            .'{"<b>MXF</b>":{"<i>Element</i>":"<img src=x onerror=alert(1)> \"quoted\""}}}}]}}';
        $client = static::createClient();
        $client->request('GET', '/MoreInfo', ['mi' => $report]);
        $content = $client->getResponse()->getContent();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNotContains('<img src=x', $content);
        $this->assertNotContains('<b>MXF</b>', $content);
        $this->assertContains('&lt;b&gt;MXF&lt;/b&gt;/&lt;i&gt;Element&lt;/i&gt;', $content);
        $this->assertContains('&lt;img src=x onerror=alert(1)&gt; &quot;quoted&quot;', $content);
    }
}
