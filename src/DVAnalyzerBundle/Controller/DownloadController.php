<?php

namespace DVAnalyzerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DownloadController extends Controller
{
    /**
     * @Route("/DVAnalyzer/Download", name="dv_download")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/Windows",
     *     name="dv_download_windows"
     * )
     * @Template()
     */
    public function windowsAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/Mac_OS",
     *     name="dv_download_mac"
     * )
     * @Template()
     */
    public function macAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/Flatpak",
     *     name="dv_download_flatpak"
     * )
     * @Template()
     */
    public function flatpakAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/Debian",
     *     name="dv_download_debian"
     * )
     * @Template()
     */
    public function debianAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/Ubuntu",
     *     name="dv_download_ubuntu"
     * )
     * @Template()
     */
    public function ubuntuAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/RHEL",
     *     name="dv_download_rhel"
     * )
     * @Template()
     */
    public function rhelAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/CentOS",
     *     name="dv_download_centos"
     * )
     * @Template()
     */
    public function centosAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/Fedora",
     *     name="dv_download_fedora"
     * )
     * @Template()
     */
    public function fedoraAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/openSUSE",
     *     name="dv_download_opensuse"
     * )
     * @Template()
     */
    public function opensuseAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/SLE",
     *     name="dv_download_sle"
     * )
     * @Template()
     */
    public function sleAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/Mageia",
     *     name="dv_download_mageia"
     * )
     * @Template()
     */
    public function mageiaAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/Arch_Linux",
     *     name="dv_download_archlinux"
     * )
     * @Template()
     */
    public function archlinuxAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/DVAnalyzer/Download/Source",
     *     name="dv_download_source"
     * )
     * @Template()
     */
    public function sourceAction()
    {
        return array();
    }
}
