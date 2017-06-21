<?php

namespace AppBundle\Lib\DownloadInfo;

interface DownloadInfoInterface
{
    public function parse();
    public function setUserAgent($userAgent);
    public function getName();
    public function getRoute();
    public function getVersion();
}
