<?php

namespace RAWcookedBundle\Lib\DownloadInfo;

use AppBundle\Lib\DownloadInfo\AbstractDownloadInfo;
use DeviceDetector\Parser\OperatingSystem as OSParser;

class RAWcookedDownloadInfo extends AbstractDownloadInfo
{
    protected $supportedOS = array(
        'Arch Linux' => array('name' => 'Arch Linux', 'route' => 'rawcooked_download_archlinux'),
        'CentOS' => array('name' => 'CentOS', 'route' => 'rawcooked_download_centos'),
        'Rocky Linux' => array('name' => 'Rocky Linux', 'route' => 'rawcooked_download_rockylinux'),
        'Debian' => array('name' => 'Debian', 'route' => 'rawcooked_download_debian'),
        'Fedora' => array('name' => 'Fedora', 'route' => 'rawcooked_download_fedora'),
        'Kubuntu' => array('name' => 'Ubuntu', 'route' => 'rawcooked_download_ubuntu'),
        'Lubuntu' => array('name' => 'Ubuntu', 'route' => 'rawcooked_download_ubuntu'),
        'Mac' => array('name' => 'macOS', 'route' => 'rawcooked_download_mac'),
        'Mint' => array('name' => 'Linux Mint', 'route' => 'rawcooked_download_ubuntu'),
        'Red Hat' => array('name' => 'RHEL', 'route' => 'rawcooked_download_rhel'),
        'SUSE' => array('name' => 'openSUSE', 'route' => 'rawcooked_download_opensuse'),
        'Ubuntu' => array('name' => 'Ubuntu', 'route' => 'rawcooked_download_ubuntu'),
        'Windows' => array('name' => 'Windows', 'route' => 'rawcooked_download_windows'),
        'Xubuntu' => array('name' => 'Ubuntu', 'route' => 'rawcooked_download_ubuntu'),
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

        return array('name' => false, 'route' => 'rawcooked_download');
    }

    public function parse()
    {
        $this->downloadInfo = $this->detectOS();
        $this->downloadInfo['version'] = '23.12';
        $this->downloadInfo['date'] = '2023-12-18';
        $this->downloadInfo['versionPath'] = '23.12';
    }

    public function getVersionPath()
    {
        return $this->downloadInfo['versionPath'];
    }
}
