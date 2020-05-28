<?php

namespace BWFMetaEditBundle\Lib\DownloadInfo;

use AppBundle\Lib\DownloadInfo\AbstractDownloadInfo;
use DeviceDetector\Parser\OperatingSystem as OSParser;

class BWFMetaEditDownloadInfo extends AbstractDownloadInfo
{
    protected $supportedOS = array(
        'Arch Linux' => array('name' => 'Arch Linux', 'route' => 'bwf_download_archlinux'),
        'CentOS' => array('name' => 'CentOS', 'route' => 'bwf_download_centos'),
        'Debian' => array('name' => 'Debian', 'route' => 'bwf_download_debian'),
        'Raspbian' => array('name' => 'Raspbian', 'route' => 'bwf_download_raspbian'),
        'Fedora' => array('name' => 'Fedora', 'route' => 'bwf_download_fedora'),
        'Flatpak' => array('name' => 'Flatpak', 'route' => 'bwf_download_flatpak'),
        'Kubuntu' => array('name' => 'Ubuntu', 'route' => 'bwf_download_ubuntu'),
        'Lubuntu' => array('name' => 'Ubuntu', 'route' => 'bwf_download_ubuntu'),
        'Mac' => array('name' => 'macOS', 'route' => 'bwf_download_mac'),
        'Mint' => array('name' => 'Linux Mint', 'route' => 'bwf_download_ubuntu'),
        'Red Hat' => array('name' => 'RHEL', 'route' => 'bwf_download_rhel'),
        'SUSE' => array('name' => 'openSUSE', 'route' => 'bwf_download_opensuse'),
        'Ubuntu' => array('name' => 'Ubuntu', 'route' => 'bwf_download_ubuntu'),
        'Windows' => array('name' => 'Windows', 'route' => 'bwf_download_windows'),
        'Xubuntu' => array('name' => 'Ubuntu', 'route' => 'bwf_download_ubuntu'),
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

        return array('name' => false, 'route' => 'bwf_download');
    }

    public function parse()
    {
        $this->downloadInfo = $this->detectOS();
        $this->downloadInfo['version'] = '20.05';
        $this->downloadInfo['date'] = '2020-05-28';
    }
}
