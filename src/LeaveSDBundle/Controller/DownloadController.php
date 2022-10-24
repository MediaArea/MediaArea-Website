<?php

namespace LeaveSDBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DownloadController extends Controller
{
    /**
     * @Route("/LeaveSD/Download", name="leavesd_download")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/LeaveSD/Download/Windows",
     *     name="leavesd_download_windows"
     * )
     * @Template()
     */
    public function windowsAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/LeaveSD/Download/Source",
     *     name="leavesd_download_source"
     * )
     * @Template()
     */
    public function sourceAction()
    {
        return array();
    }
}
