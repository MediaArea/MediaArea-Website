<?php

namespace BlogBundle\Lib;

use FilterIterator;

class PostsTagFilter extends FilterIterator
{
    protected $posts;
    protected $tagFilter;

    public function __construct(Posts $posts, $filter)
    {
        parent::__construct($posts);
        $this->tagFilter = $filter;
    }

    public function accept()
    {
        $post = $this->getInnerIterator()->current();
        if ($post->hasTagSlug($this->tagFilter)) {
            return true;
        }

        return false;
    }
}
