<?php

namespace AVIMetaEditBundle\Lib\DownloadInfo;

use AppBundle\Lib\DownloadInfo\AbstractDownloadInfo;
use DeviceDetector\Parser\OperatingSystem as OSParser;

class AVIMetaEditDownloadInfo extends AbstractDownloadInfo
{
    protected $supportedOS = array(
        'Arch Linux' => array('name' => 'Arch Linux', 'route' => 'avi_download_archlinux'),
        'CentOS' => array('name' => 'CentOS', 'route' => 'avi_download_centos'),
        'Debian' => array('name' => 'Debian', 'route' => 'avi_download_debian'),
        'Fedora' => array('name' => 'Fedora', 'route' => 'avi_download_fedora'),
        'Kubuntu' => array('name' => 'Ubuntu', 'route' => 'avi_download_ubuntu'),
        'Lubuntu' => array('name' => 'Ubuntu', 'route' => 'avi_download_ubuntu'),
        'Mac' => array('name' => 'macOS', 'route' => 'avi_download_mac'),
        'Mint' => array('name' => 'Linux Mint', 'route' => 'avi_download_ubuntu'),
        'Red Hat' => array('name' => 'RHEL', 'route' => 'avi_download_rhel'),
        'SUSE' => array('name' => 'openSUSE', 'route' => 'avi_download_opensuse'),
        'Ubuntu' => array('name' => 'Ubuntu', 'route' => 'avi_download_ubuntu'),
        'Windows' => array('name' => 'Windows', 'route' => 'avi_download_windows'),
        'Xubuntu' => array('name' => 'Ubuntu', 'route' => 'avi_download_ubuntu'),
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

        return array('name' => false, 'route' => 'avi_download');
    }

    public function parse()
    {
        $this->downloadInfo = $this->detectOS();
        $this->downloadInfo['version'] = '1.0.1';
    }
}
