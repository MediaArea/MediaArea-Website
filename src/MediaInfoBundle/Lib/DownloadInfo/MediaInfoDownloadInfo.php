<?php

namespace MediaInfoBundle\Lib\DownloadInfo;

use AppBundle\Lib\DownloadInfo\AbstractDownloadInfo;
use DeviceDetector\Parser\OperatingSystem as OSParser;

class MediaInfoDownloadInfo extends AbstractDownloadInfo
{
    protected $supportedOS = array(
        'Arch Linux' => array('name' => 'Arch Linux', 'route' => 'mi_download_archlinux', 'installer' => false),
        'CentOS' => array('name' => 'CentOS', 'route' => 'mi_download_centos', 'installer' => false),
        'Debian' => array('name' => 'Debian', 'route' => 'mi_download_debian', 'installer' => false),
        'Raspbian' => array('name' => 'Raspbian', 'route' => 'mi_download_raspbian', 'installer' => false),
        'Fedora' => array('name' => 'Fedora', 'route' => 'mi_download_fedora', 'installer' => false),
        'Kubuntu' => array('name' => 'Ubuntu', 'route' => 'mi_download_ubuntu', 'installer' => false),
        'Lubuntu' => array('name' => 'Ubuntu', 'route' => 'mi_download_ubuntu', 'installer' => false),
        'Android' => array('name' => 'Android', 'route' => 'mi_download_android', 'installer' => false),
        'Mac' => array('name' => 'macOS', 'route' => 'mi_download_mac', 'installer' => true),
        'Mandriva' => array('name' => 'Mandriva', 'route' => 'mi_download_mandriva', 'installer' => false),
        'Mint' => array('name' => 'Linux Mint', 'route' => 'mi_download_ubuntu', 'installer' => false),
        'Red Hat' => array('name' => 'RHEL', 'route' => 'mi_download_rhel', 'installer' => false),
        'RockyLinux' => array('name' => 'RockyLinux', 'route' => 'mi_download_rockylinux', 'installer' => false),
        'SUSE' => array('name' => 'openSUSE', 'route' => 'mi_download_opensuse', 'installer' => false),
        'Slackware' => array('name' => 'Slackware', 'route' => 'mi_download_slackware', 'installer' => false),
        'Solaris' => array('name' => 'Solaris', 'route' => 'mi_download_solaris', 'installer' => false),
        'Ubuntu' => array('name' => 'Ubuntu', 'route' => 'mi_download_ubuntu', 'installer' => false),
        'Windows' => array('name' => 'Windows', 'route' => 'mi_download_windows', 'installer' => true),
        'Xubuntu' => array('name' => 'Ubuntu', 'route' => 'mi_download_ubuntu', 'installer' => false),
        'Android' => array('name' => 'Android', 'route' => 'mi_download_android', 'installer' => true),
        'iOS' => array('name' => 'iOS', 'route' => 'mi_download_ios', 'installer' => false)
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

        return array('name' => false, 'route' => 'mi_download', 'installer' => false);
    }

    public function parse()
    {
        $this->downloadInfo = $this->detectOS();
        $this->downloadInfo['version'] = '23.10';
        $this->downloadInfo['date'] = '2023-10-04';
    }
}
