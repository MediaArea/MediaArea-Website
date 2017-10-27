<?php

namespace BlogBundle\Model;

class Post
{
    protected $title;
    protected $date;
    protected $excerpt;
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
