<?php

namespace MediaConchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/MediaConch/Download")
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DownloadController extends Controller
{
    /**
     * @Route("", name="mc_download")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/Windows", name="mc_download_windows")
     * @Template()
     */
    public function windowsAction()
    {
        return [];
    }

    /**
     * @Route("/Mac_OS", name="mc_download_mac")
     * @Template()
     */
    public function macAction()
    {
        return [];
    }

    /**
     * @Route("/AppImage", name="mc_download_appimage")
     * @Template()
     */
    public function appimageAction()
    {
        return [];
    }

    /**
     * @Route("/Flatpak", name="mc_download_flatpak")
     * @Template()
     */
    public function flatpakAction()
    {
        return [];
    }

    /**
     * @Route("/Debian", name="mc_download_debian")
     * @Template()
     */
    public function debianAction()
    {
        return [];
    }

    /**
     * @Route("/Ubuntu", name="mc_download_ubuntu")
     * @Template()
     */
    public function ubuntuAction()
    {
        return [];
    }

    /**
     * @Route("/RHEL", name="mc_download_rhel")
     * @Template()
     */
    public function rhelAction()
    {
        return [];
    }

    /**
     * @Route("/CentOS", name="mc_download_centos")
     * @Template()
     */
    public function centosAction()
    {
        return [];
    }

    /**
     * @Route("/Fedora", name="mc_download_fedora")
     * @Template()
     */
    public function fedoraAction()
    {
        return [];
    }

    /**
     * @Route("/openSUSE", name="mc_download_opensuse")
     * @Template()
     */
    public function opensuseAction()
    {
        return [];
    }

    /**
     * @Route("/SLE", name="mc_download_sle")
     * @Template()
     */
    public function sleAction()
    {
        return [];
    }

    /**
     * @Route("/Mageia", name="mc_download_mageia")
     * @Template()
     */
    public function mageiaAction()
    {
        return [];
    }

    /**
     * @Route("/Arch_Linux", name="mc_download_archlinux")
     * @Template()
     */
    public function archlinuxAction()
    {
        return [];
    }

    /**
     * @Route("/Source", name="mc_download_source")
     * @Template()
     */
    public function sourceAction()
    {
        return [];
    }

    /**
     * @Route("/Linuxbrew", name="mc_download_linuxbrew")
     * @Template()
     */
    public function linuxbrewAction()
    {
        return [];
    }

    /**
     * @Route("/Snapshots", name="mc_download_snapshots")
     * @Template()
     */
    public function snapshotsAction()
    {
        return [];
    }
}
