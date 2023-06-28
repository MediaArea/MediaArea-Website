<?php

namespace MediaConchBundle\Lib\DownloadInfo;

use AppBundle\Lib\DownloadInfo\AbstractDownloadInfo;
use DeviceDetector\Parser\OperatingSystem as OSParser;

class MediaConchDownloadInfo extends AbstractDownloadInfo
{
    protected $supportedOS = [
        'Arch Linux' => ['name' => 'Arch Linux', 'route' => 'mc_download_archlinux'],
        'CentOS' => ['name' => 'CentOS', 'route' => 'mc_download_centos'],
        'Debian' => ['name' => 'Debian', 'route' => 'mc_download_debian'],
        'Fedora' => ['name' => 'Fedora', 'route' => 'mc_download_fedora'],
        'Kubuntu' => ['name' => 'Ubuntu', 'route' => 'mc_download_ubuntu'],
        'Lubuntu' => ['name' => 'Ubuntu', 'route' => 'mc_download_ubuntu'],
        'Mac' => ['name' => 'macOS', 'route' => 'mc_download_mac'],
        'Mandriva' => ['name' => 'Mandriva', 'route' => 'mc_download_mandriva'],
        'Mint' => ['name' => 'Linux Mint', 'route' => 'mc_download_ubuntu'],
        'Red Hat' => ['name' => 'RHEL', 'route' => 'mc_download_rhel'],
        'RockyLinux' => ['name' => 'RockyLinux', 'route' => 'mc_download_rockylinux'],
        'SUSE' => ['name' => 'openSUSE', 'route' => 'mc_download_opensuse'],
        'Slackware' => ['name' => 'Slackware', 'route' => 'mc_download_slackware'],
        'Solaris' => ['name' => 'Solaris', 'route' => 'mc_download_solaris'],
        'Ubuntu' => ['name' => 'Ubuntu', 'route' => 'mc_download_ubuntu'],
        'Windows' => ['name' => 'Windows', 'route' => 'mc_download_windows'],
        'Xubuntu' => ['name' => 'Ubuntu', 'route' => 'mc_download_ubuntu'],
    ];
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

        return ['name' => false, 'route' => 'mc_download'];
    }

    public function parse()
    {
        $this->downloadInfo = $this->detectOS();
        $this->downloadInfo['version'] = '23.06';
        $this->downloadInfo['date'] = '2023-06-28';
    }
}
