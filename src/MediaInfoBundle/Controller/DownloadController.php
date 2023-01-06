<?php

namespace MediaInfoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.TooManyMethods)
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
     *     "/{_locale}/MediaInfo/Download/Android",
     *     name="mi_download_android",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function androidAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/iOS",
     *     name="mi_download_ios",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function iosAction()
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
     *     "/{_locale}/MediaInfo/Download/Flatpak",
     *     name="mi_download_flatpak",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function flatpakAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Snap",
     *     name="mi_download_snap",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function snapAction()
    {
        return array();
    }
    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Download/Lambda",
     *     name="mi_download_lambda",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function lambdaAction()
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
     *     "/{_locale}/MediaInfo/Download/Raspbian",
     *     name="mi_download_raspbian",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function raspbianAction()
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
     *     "/{_locale}/MediaInfo/Download/RockyLinux",
     *     name="mi_download_rockylinux",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function rockylinuxAction()
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
     *     "/{_locale}/MediaInfo/Download/JavaScript",
     *     name="mi_download_javascript",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function javascriptAction()
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
