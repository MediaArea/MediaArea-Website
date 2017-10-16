<?php

namespace MediaInfoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DownloadController extends Controller
{
    /**
     * @Route("/{_locale}/MediaInfo/Download", name="mi_download", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Windows",
     *     name="mi_download_windows",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function windowsAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Mac_OS",
     *     name="mi_download_mac",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function macAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/AppImage",
     *     name="mi_download_appimage",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function appimageAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Debian",
     *     name="mi_download_debian",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function debianAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Ubuntu",
     *     name="mi_download_ubuntu",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function ubuntuAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/RHEL",
     *     name="mi_download_rhel",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function rhelAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/CentOS",
     *     name="mi_download_centos",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function centosAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Fedora",
     *     name="mi_download_fedora",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function fedoraAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/openSUSE",
     *     name="mi_download_opensuse",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function opensuseAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/SLE",
     *     name="mi_download_sle",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function sleAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Mandriva",
     *     name="mi_download_mandriva",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function mandrivaAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Solaris",
     *     name="mi_download_solaris",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function solarisAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Mageia",
     *     name="mi_download_mageia",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function mageiaAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Arch_Linux",
     *     name="mi_download_archlinux",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function archlinuxAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Gentoo",
     *     name="mi_download_gentoo",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function gentooAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Manjaro",
     *     name="mi_download_manjaro",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function manjaroAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/PCLinuxOS",
     *     name="mi_download_pclinuxos",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function pclinuxosAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Slackware",
     *     name="mi_download_slackware",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function slackwareAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Source",
     *     name="mi_download_source",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function sourceAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Snapshots",
     *     name="mi_download_snapshots",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function snapshotsAction()
    {
        return array();
    }
}
