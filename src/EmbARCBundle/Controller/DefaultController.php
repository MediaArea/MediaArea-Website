<?php

namespace EmbARCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/embARC", name="embarc_home")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        // Download infos
        $downloadInfo = $this->get('embarc.download_info');
        $downloadInfo->setUserAgent($request->headers->get('User-Agent'));
        $downloadInfo->parse();

        return array(
            'downloadInfo' => $downloadInfo,
        );
    }

    /**
     * @Route("/embARC/License", name="embarc_license")
     * @Template()
     */
    public function licenseAction()
    {
        return array();
    }

    /**
     * @Route("/embARC/man", name="embarc_man")
     * @Template()
     */
    public function manAction()
    {
        return array();
    }
}
