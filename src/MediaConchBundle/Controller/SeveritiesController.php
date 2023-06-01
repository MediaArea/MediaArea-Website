<?php

namespace MediaConchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MediaConchBundle\Lib\Checks\Severities;

/**
 * @Route("/Severities")
 */
class SeveritiesController extends Controller
{
    /**
     * @Route("", name="severities_home")
     * @Template()
     */
    public function severitiesAction(Severities $severities)
    {
        header('X-Robots-Tag: none');

        $items = $severities->listSeverities();
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }
    
    /**
     * @Route("/{severityId}", name="severities_1")
     * @Template()
     */
    public function severity1Action($severityId, Severities $severities)
    {
        header('X-Robots-Tag: none');

        $items = $severities->listSeverityInfo($severityId);
        if (!$items) {
            throw $this->createNotFoundException('The severity is not found in our database');
        }
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }
}
