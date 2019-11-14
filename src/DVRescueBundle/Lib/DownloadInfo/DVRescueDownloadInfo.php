<?php

namespace DVRescueBundle\Lib\DownloadInfo;

use AppBundle\Lib\DownloadInfo\AbstractDownloadInfo;
use DeviceDetector\Parser\OperatingSystem as OSParser;

class DVRescueDownloadInfo extends AbstractDownloadInfo
{
    protected $supportedOS = array(
        'Arch Linux' => array('name' => 'Arch Linux', 'route' => 'dvrescue_download_archlinux'),
        'CentOS' => array('name' => 'CentOS', 'route' => 'dvrescue_download_centos'),
        'Debian' => array('name' => 'Debian', 'route' => 'dvrescue_download_debian'),
        'Fedora' => array('name' => 'Fedora', 'route' => 'dvrescue_download_fedora'),
        'Kubuntu' => array('name' => 'Ubuntu', 'route' => 'dvrescue_download_ubuntu'),
        'Lubuntu' => array('name' => 'Ubuntu', 'route' => 'dvrescue_download_ubuntu'),
        'Mac' => array('name' => 'macOS', 'route' => 'dvrescue_download_mac'),
        'Mint' => array('name' => 'Linux Mint', 'route' => 'dvrescue_download_ubuntu'),
        'Red Hat' => array('name' => 'RHEL', 'route' => 'dvrescue_download_rhel'),
        'SUSE' => array('name' => 'openSUSE', 'route' => 'dvrescue_download_opensuse'),
        'Ubuntu' => array('name' => 'Ubuntu', 'route' => 'dvrescue_download_ubuntu'),
        'Windows' => array('name' => 'Windows', 'route' => 'dvrescue_download_windows'),
        'Xubuntu' => array('name' => 'Ubuntu', 'route' => 'dvrescue_download_ubuntu'),
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

        return array('name' => false, 'route' => 'dvrescue_download');
    }

    public function parse()
    {
        $this->downloadInfo = $this->detectOS();
        $this->downloadInfo['version'] = '0.19.11';
        $this->downloadInfo['date'] = '2019-11-14';
        $this->downloadInfo['versionPath'] = '0.19.11';
    }

    public function getVersionPath()
    {
        return $this->downloadInfo['versionPath'];
    }
}
