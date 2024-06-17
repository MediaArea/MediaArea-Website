<?php

namespace MOVMetaEditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DownloadController extends Controller
{
    /**
     * @Route("/MOVMetaEdit/Download", name="mov_download")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/Windows",
     *     name="mov_download_windows"
     * )
     * @Template()
     */
    public function windowsAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/Mac_OS",
     *     name="mov_download_mac"
     * )
     * @Template()
     */
    public function macAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/Flatpak",
     *     name="mov_download_flatpak"
     * )
     * @Template()
     */
    public function flatpakAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/Debian",
     *     name="mov_download_debian"
     * )
     * @Template()
     */
    public function debianAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/Ubuntu",
     *     name="mov_download_ubuntu"
     * )
     * @Template()
     */
    public function ubuntuAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/RHEL",
     *     name="mov_download_rhel"
     * )
     * @Template()
     */
    public function rhelAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/CentOS",
     *     name="mov_download_centos"
     * )
     * @Template()
     */
    public function centosAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/RockyLinux",
     *     name="mov_download_rockylinux"
     * )
     * @Template()
     */
    public function rockylinuxAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/Fedora",
     *     name="mov_download_fedora"
     * )
     * @Template()
     */
    public function fedoraAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/openSUSE",
     *     name="mov_download_opensuse"
     * )
     * @Template()
     */
    public function opensuseAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/SLE",
     *     name="mov_download_sle"
     * )
     * @Template()
     */
    public function sleAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/Mageia",
     *     name="mov_download_mageia"
     * )
     * @Template()
     */
    public function mageiaAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/Arch_Linux",
     *     name="mov_download_archlinux"
     * )
     * @Template()
     */
    public function archlinuxAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/MOVMetaEdit/Download/Source",
     *     name="mov_download_source"
     * )
     * @Template()
     */
    public function sourceAction()
    {
        return array();
    }
}
