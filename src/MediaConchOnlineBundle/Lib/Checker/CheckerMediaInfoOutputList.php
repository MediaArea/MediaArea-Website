<?php

namespace MediaConchOnlineBundle\Lib\Checker;

class CheckerMediaInfoOutputList extends CheckerBase
{
    public function getList()
    {
        $this->response = $this->mc->mediaInfoOutputList();
    }

    public function getResponseAsArray()
    {
        return ['list' => $this->response->getList()];
    }
}
