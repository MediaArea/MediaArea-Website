<?php

namespace QCToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/QCTools", name="qc_home")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        // Download infos
        $downloadInfo = $this->get('qc.download_info');
        $downloadInfo->setUserAgent($request->headers->get('User-Agent'));
        $downloadInfo->parse();

        return array(
            'downloadInfo' => $downloadInfo,
        );
    }

    /**
     * @Route("/QCTools/License", name="qc_license")
     * @Template()
     */
    public function licenseAction()
    {
        return array();
    }
}
