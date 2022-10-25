<?php

namespace LeaveSDBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/LeaveSD", name="leavesd_home")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        // Download infos
        $downloadInfo = $this->get('leavesd.download_info');
        $downloadInfo->setUserAgent($request->headers->get('User-Agent'));
        $downloadInfo->parse();

        return array(
            'downloadInfo' => $downloadInfo,
        );
    }

    /**
     * @Route("/LeaveSD/License", name="leavesd_license")
     * @Template()
     */
    public function licenseAction()
    {
        return array();
    }

    /**
     * @Route("/LeaveSD/man", name="leavesd_man")
     * @Template()
     */
    public function manAction()
    {
        return array();
    }
}
