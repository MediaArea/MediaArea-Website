<?php

namespace MediaConchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MediaConchBundle\Lib\DownloadInfo\MediaConchDownloadInfo;

/**
 * @Route("/MediaConch")
 */
class DefaultController extends Controller
{
    /**
     * @Route("", name="mc_home")
     * @Template()
     */
    public function indexAction(Request $request, MediaConchDownloadInfo $downloadInfo)
    {
        // Download infos
        $downloadInfo->setUserAgent($request->headers->get('User-Agent'));
        $downloadInfo->parse();

        return [
            'downloadInfo' => $downloadInfo,
        ];
    }

    /**
     * @Route("/Team", name="mc_team")
     * @Template()
     */
    public function teamAction()
    {
        return [];
    }

    /**
     * @Route("/Community", name="mc_community")
     * @Template()
     */
    public function communityAction()
    {
        return [];
    }
}
