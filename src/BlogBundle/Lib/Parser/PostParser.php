<?php

namespace BlogBundle\Lib\Parser;

use BlogBundle\Model\Post;

class PostParser
{
    protected $post;

    public function __construct($file)
    {
        if ('.md' != substr($file, -3)) {
            throw new \Exception('Post format unknown');
        }
        if (!file_exists($file)) {
            throw new \Exception('Post do not exists');
        }

        $this->post = new Post();
        $this->parse($file);
        $this->hydratePostUrlParams($file);
    }

    public function getPost()
    {
        return $this->post;
    }

    protected function parse($file)
    {
        $post = file_get_contents($file);
        $post = trim(substr($post, strpos($post, '---') + 3));
        $this->hydratePostInfos(substr($post, 0, strpos($post, '---')));
        $this->hydratePostContent(trim(substr($post, strpos($post, '---') + 3)));
    }

    protected function hydratePostInfos($postInfos)
    {
        // Parse title
        if (preg_match('#title:\s*"(.*?)"#', $postInfos, $matches)) {
            $this->post->setTitle($matches[1]);
        }

        // Parse date
        if (preg_match('#date:\s*(.*)#', $postInfos, $matches)) {
            $this->post->setDate(new \DateTime($matches[1]));
        }

        // Parse excerpt
        if (preg_match('#excerpt:\s*"(.*?)"#', $postInfos, $matches)) {
            $this->post->setExcerpt($matches[1]);
        }
    }

    protected function hydratePostContent($postContent)
    {
        $this->post->setContent($postContent);
    }

    protected function hydratePostUrlParams($file)
    {
        if (preg_match('#(\d{4})-(\d{2})-(\d{2})-(.*).md$#', $file, $matches)) {
            $this->post->setUrlParams([
                'year' => $matches[1],
                'month' => $matches[2],
                'day' => $matches[3],
                'slug' => $matches[4],
            ]);
        }
    }
}
