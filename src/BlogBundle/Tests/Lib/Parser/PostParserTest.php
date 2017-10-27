<?php

namespace BlogBundle\Tests\Lib\Parser;

use BlogBundle\Lib\Parser\PostParser;
use PHPUnit\Framework\TestCase;

class PostParserTest extends TestCase
{
    public function testPostParser()
    {
        $file = __DIR__.'/../../data/Posts/2017-08-22-interview-with-julia-kim.md';
        $postParser = new PostParser($file);
        $post = $postParser->getPost();

        $this->assertEquals('Interview with Julia Kim', $post->getTitle());
        $this->assertEquals('2017-08-22', $post->getDate()->format('Y-m-d'));
        $this->assertEquals(null, $post->getExcerpt());
        $this->assertEquals([
            'year' => '2017',
            'month' => '08',
            'day' => '22',
            'slug' => 'interview-with-julia-kim',
        ], $post->getUrlParams());
        $this->assertContains('# Interview with Julia Kim', $post->getContent());
        $this->assertContains('<h1>Interview with Julia Kim</h1>', $post->getHtmlContent());
    }

    public function testPostParserNypl()
    {
        $file = __DIR__.'/../../data/Posts/2017-09-07-interview-with-ben-turkus-genevieve-havemeyer-king-nypl.md';
        $postParser = new PostParser($file);
        $post = $postParser->getPost();

        $this->assertEquals('Interview with Ben Turkus and Genevieve Havemeyer-King', $post->getTitle());
        $this->assertEquals('2017-09-06', $post->getDate()->format('Y-m-d'));
        $this->assertEquals(null, $post->getExcerpt());
        $this->assertEquals([
            'year' => '2017',
            'month' => '09',
            'day' => '07',
            'slug' => 'interview-with-ben-turkus-genevieve-havemeyer-king-nypl',
        ], $post->getUrlParams());
        $this->assertContains('# Interview with Ben Turkus and Genevieve Havemeyer-King of NYPL', $post->getContent());
        $this->assertContains(
            '<h1>Interview with Ben Turkus and Genevieve Havemeyer-King of NYPL</h1>',
            $post->getHtmlContent()
        );
    }
}
