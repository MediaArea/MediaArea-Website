<?php

namespace MediaConchOnlineBundle\Lib\MediaInfo;

class MediaInfoOutput
{
    private $xml;
    private $tracks = [];

    public function __construct($xml)
    {
        $this->xml = $xml;
        $this->validateXml();
        $this->hydrateXml();
    }

    private function hydrateXml()
    {
        $xml = new \SimpleXMLElement($this->xml);
        foreach ($xml->File->track as $track) {
            $this->setTrack($track);
        }
    }

    private function validateXml()
    {
    }

    private function setTrack($track)
    {
        if (isset($track['type'])) {
            $type = $track['type']->__toString();

            if (!isset($this->tracks[$type])) {
                $this->tracks[$type] = [];
            }

            $id = 1;
            if (isset($track['streamid']) && is_int($track['streamid'])) {
                $id = $track['streamid'];
            }

            $class = 'MediaConchOnlineBundle\Lib\MediaInfo\MediaInfoOutput'.$type;
            $this->tracks[$type][$id] = new $class($track);
        }
    }

    public function getTracks()
    {
        return $this->tracks;
    }

    public function getTracksList()
    {
        return array_keys($this->tracks);
    }

    public function getTrack($type, $id = null)
    {
        if (isset($this->tracks[$type])) {
            if (null !== $id && isset($this->tracks[$type][$id])) {
                return $this->tracks[$type][$id];
            } elseif (null === $id) {
                return $this->tracks[$type];
            }
        }

        return false;
    }

    public function isTrackMulti($type)
    {
        return isset($this->tracks[$type]) && 1 < count($this->tracks[$type]);
    }

    public function isTrackExists($type, $id = null)
    {
        if (null === $id) {
            return isset($this->tracks[$type]);
        } else {
            return isset($this->tracks[$type][$id]);
        }
    }
}
