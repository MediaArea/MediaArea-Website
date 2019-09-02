<?php

namespace AppBundle\Lib\DownloadInfo;

abstract class AbstractDownloadInfo implements DownloadInfoInterface
{
    protected $supportedOS = array();
    protected $userAgent;
    protected $downloadInfo;

    abstract protected function detectOS();

    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    public function getName()
    {
        return $this->downloadInfo['name'];
    }

    public function getRoute()
    {
        return $this->downloadInfo['route'];
    }

    public function getInstaller()
    {
        return $this->downloadInfo['installer'];
    }

    public function getVersion()
    {
        return $this->downloadInfo['version'];
    }

    public function getDate()
    {
        return $this->downloadInfo['date'];
    }
}
