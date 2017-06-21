<?php

namespace QCToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DownloadController extends Controller
{
    /**
     * @Route("/QCTools/Download", name="qc_download")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/Windows",
     *     name="qc_download_windows"
     * )
     * @Template()
     */
    public function windowsAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/Mac_OS",
     *     name="qc_download_mac"
     * )
     * @Template()
     */
    public function macAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/AppImage",
     *     name="qc_download_appimage"
     * )
     * @Template()
     */
    public function appimageAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/Debian",
     *     name="qc_download_debian"
     * )
     * @Template()
     */
    public function debianAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/Ubuntu",
     *     name="qc_download_ubuntu"
     * )
     * @Template()
     */
    public function ubuntuAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/RHEL",
     *     name="qc_download_rhel"
     * )
     * @Template()
     */
    public function rhelAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/CentOS",
     *     name="qc_download_centos"
     * )
     * @Template()
     */
    public function centosAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/Fedora",
     *     name="qc_download_fedora"
     * )
     * @Template()
     */
    public function fedoraAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/openSUSE",
     *     name="qc_download_opensuse"
     * )
     * @Template()
     */
    public function opensuseAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/SLE",
     *     name="qc_download_sle"
     * )
     * @Template()
     */
    public function sleAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/Mageia",
     *     name="qc_download_mageia"
     * )
     * @Template()
     */
    public function mageiaAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/Arch_Linux",
     *     name="qc_download_archlinux"
     * )
     * @Template()
     */
    public function archlinuxAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/QCTools/Download/Source",
     *     name="qc_download_source"
     * )
     * @Template()
     */
    public function sourceAction()
    {
        return array();
    }
}
