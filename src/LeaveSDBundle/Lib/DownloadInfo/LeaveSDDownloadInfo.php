<?php

namespace LeaveSDBundle\Lib\DownloadInfo;

use AppBundle\Lib\DownloadInfo\AbstractDownloadInfo;
use DeviceDetector\Parser\OperatingSystem as OSParser;

class LeaveSDDownloadInfo extends AbstractDownloadInfo
{
    protected $supportedOS = array(
        'Windows' => array('name' => 'Windows', 'route' => 'leavesd_download_windows'),
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

        return array('name' => false, 'route' => 'leavesd_download');
    }

    public function parse()
    {
        $this->downloadInfo = $this->detectOS();
        $this->downloadInfo['version'] = '0.1.5';
        $this->downloadInfo['date'] = '2022-03-06';
        $this->downloadInfo['versionPath'] = '0.1.5';
    }

    public function getVersionPath()
    {
        return $this->downloadInfo['versionPath'];
    }
}
