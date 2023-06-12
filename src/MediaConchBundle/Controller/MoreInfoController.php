<?php

namespace MediaConchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MediaConchBundle\Lib\Checks\Checks;

/**
 * @Route("/MoreInfo")
 */
class MoreInfoController extends Controller
{
    /**
     * @Route("", name="moreinfo_home")
     * @Template()
     */
    public function analyzeAction(Request $request, Checks $checks)
    {
        header('X-Robots-Tag: none');

        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $checks->analyzeMediaInfoReport($request->query->get('mi')) ]);
    }
}
