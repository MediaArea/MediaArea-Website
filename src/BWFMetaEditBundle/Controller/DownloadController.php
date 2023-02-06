<?php

namespace BWFMetaEditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DownloadController extends Controller
{
    /**
     * @Route("/BWFMetaEdit/Download", name="bwf_download")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/Windows",
     *     name="bwf_download_windows"
     * )
     * @Template()
     */
    public function windowsAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/Mac_OS",
     *     name="bwf_download_mac"
     * )
     * @Template()
     */
    public function macAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/Flatpak",
     *     name="bwf_download_flatpak"
     * )
     * @Template()
     */
    public function flatpakAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/Debian",
     *     name="bwf_download_debian"
     * )
     * @Template()
     */
    public function debianAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/Raspbian",
     *     name="bwf_download_raspbian"
     * )
     * @Template()
     */
    public function raspbianAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/Ubuntu",
     *     name="bwf_download_ubuntu"
     * )
     * @Template()
     */
    public function ubuntuAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/RHEL",
     *     name="bwf_download_rhel"
     * )
     * @Template()
     */
    public function rhelAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/RockyLinux",
     *     name="bwf_download_rockylinux"
     * )
     * @Template()
     */
    public function rockylinuxAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/CentOS",
     *     name="bwf_download_centos"
     * )
     * @Template()
     */
    public function centosAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/Fedora",
     *     name="bwf_download_fedora"
     * )
     * @Template()
     */
    public function fedoraAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/openSUSE",
     *     name="bwf_download_opensuse"
     * )
     * @Template()
     */
    public function opensuseAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/SLE",
     *     name="bwf_download_sle"
     * )
     * @Template()
     */
    public function sleAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/Mageia",
     *     name="bwf_download_mageia"
     * )
     * @Template()
     */
    public function mageiaAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/Arch_Linux",
     *     name="bwf_download_archlinux"
     * )
     * @Template()
     */
    public function archlinuxAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/BWFMetaEdit/Download/Source",
     *     name="bwf_download_source"
     * )
     * @Template()
     */
    public function sourceAction()
    {
        return array();
    }
}
