<?php

namespace MediaConchOnlineBundle\Lib\MediaInfo;

class MediaInfoOutputVideo extends MediaInfoOutputTrack
{
    protected $aliasFields = [];

    public function __construct($xml)
    {
        parent::__construct($xml);
    }

    protected function setBitRateString($key, $value)
    {
        preg_match('/([0-9\.]+) [a-zA-Z]+/', $value, $matches);
        if (is_array($matches) && isset($matches[1])) {
            $bitrate = $matches[1];
        } else {
            $bitrate = null;
        }
        $this->datas[$key] = $bitrate;
    }
}
