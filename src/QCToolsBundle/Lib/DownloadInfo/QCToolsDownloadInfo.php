<?php

namespace QCToolsBundle\Lib\DownloadInfo;

use AppBundle\Lib\DownloadInfo\AbstractDownloadInfo;
use DeviceDetector\Parser\OperatingSystem as OSParser;

class QCToolsDownloadInfo extends AbstractDownloadInfo
{
    protected $supportedOS = array(
        'Arch Linux' => array('name' => 'Arch Linux', 'route' => 'qc_download_archlinux'),
        'CentOS' => array('name' => 'CentOS', 'route' => 'qc_download_centos'),
        'Debian' => array('name' => 'Debian', 'route' => 'qc_download_debian'),
        'Fedora' => array('name' => 'Fedora', 'route' => 'qc_download_fedora'),
        'Kubuntu' => array('name' => 'Ubuntu', 'route' => 'qc_download_ubuntu'),
        'Lubuntu' => array('name' => 'Ubuntu', 'route' => 'qc_download_ubuntu'),
        'Mac' => array('name' => 'macOS', 'route' => 'qc_download_mac'),
        'Mint' => array('name' => 'Linux Mint', 'route' => 'qc_download_ubuntu'),
        'Red Hat' => array('name' => 'RHEL', 'route' => 'qc_download_rhel'),
        'SUSE' => array('name' => 'openSUSE', 'route' => 'qc_download_opensuse'),
        'Ubuntu' => array('name' => 'Ubuntu', 'route' => 'qc_download_ubuntu'),
        'Windows' => array('name' => 'Windows', 'route' => 'qc_download_windows'),
        'Xubuntu' => array('name' => 'Ubuntu', 'route' => 'qc_download_ubuntu'),
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

        return array('name' => false, 'route' => 'qc_download');
    }

    public function parse()
    {
        $this->downloadInfo = $this->detectOS();
        $this->downloadInfo['version'] = '0.8';
    }
}
