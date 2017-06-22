<?php

namespace DVAnalyzerBundle\Lib\DownloadInfo;

use AppBundle\Lib\DownloadInfo\AbstractDownloadInfo;
use DeviceDetector\Parser\OperatingSystem as OSParser;

class DVAnalyzerDownloadInfo extends AbstractDownloadInfo
{
    protected $supportedOS = array(
        'Arch Linux' => array('name' => 'Arch Linux', 'route' => 'dv_download_archlinux'),
        'CentOS' => array('name' => 'CentOS', 'route' => 'dv_download_centos'),
        'Debian' => array('name' => 'Debian', 'route' => 'dv_download_debian'),
        'Fedora' => array('name' => 'Fedora', 'route' => 'dv_download_fedora'),
        'Kubuntu' => array('name' => 'Ubuntu', 'route' => 'dv_download_ubuntu'),
        'Lubuntu' => array('name' => 'Ubuntu', 'route' => 'dv_download_ubuntu'),
        'Mac' => array('name' => 'macOS', 'route' => 'dv_download_mac'),
        'Mint' => array('name' => 'Linux Mint', 'route' => 'dv_download_ubuntu'),
        'Red Hat' => array('name' => 'RHEL', 'route' => 'dv_download_rhel'),
        'SUSE' => array('name' => 'openSUSE', 'route' => 'dv_download_opensuse'),
        'Ubuntu' => array('name' => 'Ubuntu', 'route' => 'dv_download_ubuntu'),
        'Windows' => array('name' => 'Windows', 'route' => 'dv_download_windows'),
        'Xubuntu' => array('name' => 'Ubuntu', 'route' => 'dv_download_ubuntu'),
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

        return array('name' => false, 'route' => 'dv_download');
    }

    public function parse()
    {
        $this->downloadInfo = $this->detectOS();
        $this->downloadInfo['version'] = '1.4.1.20160928';
    }
}
