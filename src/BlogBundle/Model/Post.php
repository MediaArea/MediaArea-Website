<?php

namespace BlogBundle\Model;

use Gedmo\Sluggable\Util\Urlizer;

class Post
{
    protected $title;
    protected $date;
    protected $excerpt;
    protected $tags = [];
    protected $content;
    protected $urlParams;

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function addTag($tag)
    {
        $this->tags[Urlizer::urlize($tag)] = $tag;

        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function getTagBySlug($tagSlug)
    {
        return $this->tags[$tagSlug] ?? false;
    }

    public function hasTagSlug($tagSlug)
    {
        return isset($this->tags[$tagSlug]);
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getHtmlContent()
    {
        $mdParser = new \Parsedown();

        return $mdParser->text($this->content);
    }

    public function setUrlParams($urlParams)
    {
        $this->urlParams = $urlParams;

        return $this;
    }

    public function getUrlParams()
    {
        return $this->urlParams;
    }
}
