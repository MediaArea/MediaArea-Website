<?php

namespace MediaConchOnlineBundle\Lib\MediaInfo;

class MediaInfoOutputGeneral extends MediaInfoOutputTrack
{
    protected $aliasFields = ['comapplequicktimemake' => 'pascomapplequicktimemake'];

    public function __construct($xml)
    {
        parent::__construct($xml);
    }

    protected function setOverallBitRateString($key, $value)
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
