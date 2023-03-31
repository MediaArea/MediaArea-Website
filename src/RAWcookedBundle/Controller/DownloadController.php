<?php

namespace RAWcookedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DownloadController extends Controller
{
    /**
     * @Route("/RAWcooked/Download", name="rawcooked_download")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/Windows",
     *     name="rawcooked_download_windows"
     * )
     * @Template()
     */
    public function windowsAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/Mac_OS",
     *     name="rawcooked_download_mac"
     * )
     * @Template()
     */
    public function macAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/Debian",
     *     name="rawcooked_download_debian"
     * )
     * @Template()
     */
    public function debianAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/Ubuntu",
     *     name="rawcooked_download_ubuntu"
     * )
     * @Template()
     */
    public function ubuntuAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/RHEL",
     *     name="rawcooked_download_rhel"
     * )
     * @Template()
     */
    public function rhelAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/CentOS",
     *     name="rawcooked_download_centos"
     * )
     * @Template()
     */
    public function centosAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/RockyLinux",
     *     name="rawcooked_download_rockylinux"
     * )
     * @Template()
     */
    public function rockylinuxAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/Fedora",
     *     name="rawcooked_download_fedora"
     * )
     * @Template()
     */
    public function fedoraAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/openSUSE",
     *     name="rawcooked_download_opensuse"
     * )
     * @Template()
     */
    public function opensuseAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/SLE",
     *     name="rawcooked_download_sle"
     * )
     * @Template()
     */
    public function sleAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/Mageia",
     *     name="rawcooked_download_mageia"
     * )
     * @Template()
     */
    public function mageiaAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/Arch_Linux",
     *     name="rawcooked_download_archlinux"
     * )
     * @Template()
     */
    public function archlinuxAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/RAWcooked/Download/Source",
     *     name="rawcooked_download_source"
     * )
     * @Template()
     */
    public function sourceAction()
    {
        return array();
    }
}
