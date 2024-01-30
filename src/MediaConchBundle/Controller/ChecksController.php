<?php

namespace MediaConchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MediaConchBundle\Lib\Checks\Checks;

/**
 * @Route("/Checks")
 */
class ChecksController extends Controller
{
    /**
     * @Route("", name="checks_home")
     * @Template()
     */
    public function checksAction(Checks $checks)
    {
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $checks->listChecks() ]);
    }
    
    /**
     * @Route("/{checkId}", name="checks_1")
     * @Template()
     */
    public function checks1Action($checkId, Checks $checks)
    {
        header('X-Robots-Tag: none');
        
        $items = $checks->listCheckInfo($checkId);
        if (!$items) {
            throw $this->createNotFoundException('The check is not found in our database');
        }
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }
}
