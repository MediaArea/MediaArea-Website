<?php

namespace MediaConchOnlineBundle\Lib\MediaInfo;

class MediaInfoOutputOther extends MediaInfoOutputTrack
{
    protected $aliasFields = [];

    public function __construct($xml)
    {
        parent::__construct($xml);
    }
}
