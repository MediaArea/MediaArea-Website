<?php

namespace MediaConchOnlineBundle\Lib\MediaConch;

class MediaInfoOutputListResponse extends MediaConchServerAbstractResponse
{
    protected $list = [];

    public function getList()
    {
        return $this->list;
    }

    protected function parse($response)
    {
        $this->list = json_decode($response->outputs);
    }
}
