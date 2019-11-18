<?php

namespace DVRescueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DownloadController extends Controller
{
    /**
     * @Route("/DVRescue/Download", name="dvrescue_download")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVRescue/Download/Windows",
     *     name="dvrescue_download_windows"
     * )
     * @Template()
     */
    public function windowsAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVRescue/Download/Mac_OS",
     *     name="dvrescue_download_mac"
     * )
     * @Template()
     */
    public function macAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVRescue/Download/Debian",
     *     name="dvrescue_download_debian"
     * )
     * @Template()
     */
    public function debianAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVRescue/Download/Ubuntu",
     *     name="dvrescue_download_ubuntu"
     * )
     * @Template()
     */
    public function ubuntuAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVRescue/Download/RHEL",
     *     name="dvrescue_download_rhel"
     * )
     * @Template()
     */
    public function rhelAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVRescue/Download/CentOS",
     *     name="dvrescue_download_centos"
     * )
     * @Template()
     */
    public function centosAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVRescue/Download/Fedora",
     *     name="dvrescue_download_fedora"
     * )
     * @Template()
     */
    public function fedoraAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVRescue/Download/openSUSE",
     *     name="dvrescue_download_opensuse"
     * )
     * @Template()
     */
    public function opensuseAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVRescue/Download/SLE",
     *     name="dvrescue_download_sle"
     * )
     * @Template()
     */
    public function sleAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVRescue/Download/Mageia",
     *     name="dvrescue_download_mageia"
     * )
     * @Template()
     */
    public function mageiaAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVRescue/Download/Arch_Linux",
     *     name="dvrescue_download_archlinux"
     * )
     * @Template()
     */
    public function archlinuxAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVRescue/Download/Source",
     *     name="dvrescue_download_source"
     * )
     * @Template()
     */
    public function sourceAction()
    {
        return array();
    }
}
