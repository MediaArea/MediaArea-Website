<?php

namespace BlogBundle\Lib;

use Countable;
use Iterator;
use Symfony\Component\Finder\Finder;
use BlogBundle\Lib\Parser\PostParser;

class Posts implements Countable, Iterator
{
    protected $position = 0;
    protected $posts;

    public function __construct($path)
    {
        $finder = new Finder();
        $finder->files()->name('*.md')->depth('== 0')->sortByName()->ignoreDotFiles(true)->ignoreVCS(true);
        $posts = [];
        foreach ($finder->in($path) as $file) {
            try {
                $postParser = new PostParser($file->getRealPath());
                $posts[] = $postParser->getPost();
            } catch (\Exception $e) {
                // Ignore post
            }
        }
        $this->posts = array_reverse($posts);
    }

    public function count()
    {
        return count($this->posts);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->posts[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return array_key_exists($this->position, $this->posts);
    }
}
