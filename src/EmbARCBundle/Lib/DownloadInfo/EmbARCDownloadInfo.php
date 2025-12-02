<?php

namespace EmbARCBundle\Lib\DownloadInfo;

use AppBundle\Lib\DownloadInfo\AbstractDownloadInfo;
use DeviceDetector\Parser\OperatingSystem as OSParser;

class EmbARCDownloadInfo extends AbstractDownloadInfo
{
    protected $supportedOS = array(
        'Windows' => array('name' => 'Windows', 'route' => 'embarc_download_windows', 'installer' => true),
        'Mac' => array('name' => 'macOS', 'route' => 'embarc_download_mac', 'installer' => true),
        'Linux' => array('name' => 'Linux', 'route' => 'embarc_download_linux', 'installer' => false),
    );
    protected $userAgent;
    protected $downloadInfo;

    protected function detectOS()
    {
        $osParser = new OSParser();
        $osParser->setUserAgent($this->userAgent);
        $detectedOS = $osParser->parse();

        if ($detectedOS && array_key_exists($detectedOS['name'], $this->supportedOS)) {
            return $this->supportedOS[$detectedOS['name']];
        }

        return array('name' => false, 'route' => 'embarc_download');
    }

    public function parse()
    {
        $this->downloadInfo = $this->detectOS();
        $this->downloadInfo['version'] = '1.4.20251129';
        $this->downloadInfo['date'] = '2025-11-29';
        $this->downloadInfo['versionPath'] = '20251129';
    }

    public function getVersionPath()
    {
        return $this->downloadInfo['versionPath'];
    }
}
