<?php

namespace MOVMetaEditBundle\Lib\DownloadInfo;

use AppBundle\Lib\DownloadInfo\AbstractDownloadInfo;
use DeviceDetector\Parser\OperatingSystem as OSParser;

class MOVMetaEditDownloadInfo extends AbstractDownloadInfo
{
    protected $supportedOS = array(
        'Arch Linux' => array('name' => 'Arch Linux', 'route' => 'mov_download_archlinux'),
        'CentOS' => array('name' => 'CentOS', 'route' => 'mov_download_centos'),
        'Debian' => array('name' => 'Debian', 'route' => 'mov_download_debian'),
        'Fedora' => array('name' => 'Fedora', 'route' => 'mov_download_fedora'),
        'Kubuntu' => array('name' => 'Ubuntu', 'route' => 'mov_download_ubuntu'),
        'Lubuntu' => array('name' => 'Ubuntu', 'route' => 'mov_download_ubuntu'),
        'Mac' => array('name' => 'macOS', 'route' => 'mov_download_mac'),
        'Mint' => array('name' => 'Linux Mint', 'route' => 'mov_download_ubuntu'),
        'Red Hat' => array('name' => 'RHEL', 'route' => 'mov_download_rhel'),
        'RockyLinux' => array('name' => 'RockyLinux', 'route' => 'mov_download_rockylinux'),
        'SUSE' => array('name' => 'openSUSE', 'route' => 'mov_download_opensuse'),
        'Ubuntu' => array('name' => 'Ubuntu', 'route' => 'mov_download_ubuntu'),
        'Windows' => array('name' => 'Windows', 'route' => 'mov_download_windows'),
        'Xubuntu' => array('name' => 'Ubuntu', 'route' => 'mov_download_ubuntu'),
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

        return array('name' => false, 'route' => 'mov_download');
    }

    public function parse()
    {
        $this->downloadInfo = $this->detectOS();
        $this->downloadInfo['version'] = '25.09';
        $this->downloadInfo['date'] = '2025-09-30';
        $this->downloadInfo['versionPath'] = '25.09';
    }

    public function getVersionPath()
    {
        return $this->downloadInfo['versionPath'];
    }
}
