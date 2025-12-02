<?php

namespace EmbARCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DownloadController extends Controller
{
    /**
     * @Route("/embARC/Download", name="embarc_download")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/embARC/Download/Windows",
     *     name="embarc_download_windows"
     * )
     * @Template()
     */
    public function windowsAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/embARC/Download/macOS",
     *     name="embarc_download_mac",
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
     *     "/embARC/Download/Linux",
     *     name="embarc_download_linux",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function linuxAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/embARC/Download/Source",
     *     name="embarc_download_source"
     * )
     * @Template()
     */
    public function sourceAction()
    {
        return array();
    }
}
