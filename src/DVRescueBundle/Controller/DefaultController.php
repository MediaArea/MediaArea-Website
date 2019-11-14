<?php

namespace DVRescueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/DVRescue", name="dvrescue_home")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        // Download infos
        $downloadInfo = $this->get('dvrescue.download_info');
        $downloadInfo->setUserAgent($request->headers->get('User-Agent'));
        $downloadInfo->parse();

        return array(
            'downloadInfo' => $downloadInfo,
        );
    }

    /**
     * @Route("/DVRescue/License", name="dvrescue_license")
     * @Template()
     */
    public function licenseAction()
    {
        return array();
    }

    /**
     * @Route("/DVRescue/man", name="dvrescue_man")
     * @Template()
     */
    public function manAction()
    {
        return array();
    }
}
