<?php

namespace MediaConchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MediaConchBundle\Lib\Checks\Specs;

/**
 * @Route("/Specs")
 */
class SpecsController extends Controller
{
    /**
     * @Route("", name="specs_home")
     * @Template()
     */
    public function specsAction(Specs $specs)
    {
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $specs->listSpecs() ]);
    }
    
    /**
     * @Route("/{specId}", name="specs_1")
     * @Template()
     */
    public function specs1Action(Specs $specs, $specId)
    {
        $items = $specs->listSpecInfo($specId);
        if (!$items) {
            throw $this->createNotFoundException('This specification is not found in our database');
        }
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }

    /**
     * @Route("/{specId}/{specId2}", name="specs_2")
     * @Template()
     */
    public function specs2Action(Specs $specs, $specId, $specId2)
    {
        $items = $specs->listElementInfo($specId, $specId2, '../../');
        if (!$items) {
            throw $this->createNotFoundException('This specification is not found in our database');
        }
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }
       
    /**
     * @Route("/{specId}/{specId2}/{specId3}", name="specs_3")
     * @Template()
     */
    public function specs3Action(Specs $specs, $specId, $specId2, $specId3)
    {
        $items = $specs->listFieldInfo($specId, $specId2, $specId3, '../../../');
        if (!$items) {
            throw $this->createNotFoundException('This specification is not found in our database');
        }
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }
       
    /**
     * @Route("/{specId}/{specId2}/{specId3}/{specId4}", name="specs_4")
     * @Template()
     */
    public function specs4Action(Specs $specs, $specId, $specId2, $specId3, $specId4)
    {
        $items = $specs->listFieldInfo($specId, $specId2 . '/' . $specId3, $specId4, '../../../../');
        if (!$items) {
            throw $this->createNotFoundException('This specification is not found in our database');
        }
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }
       
    /**
     * @Route("/{specId}/{specId2}/{specId3}/{specId4}/{specId5}", name="specs_5")
     * @Template()
     */
    public function specs5Action(Specs $specs, $specId, $specId2, $specId3, $specId4, $specId5)
    {
        $items = $specs->listFieldInfo($specId, $specId2 . '/' . $specId3 . '/' . $specId4, $specId5, '../../../../../');
        if (!$items) {
            throw $this->createNotFoundException('This specification is not found in our database');
        }
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }
       
    /**
     * @Route("/{specId}/{specId2}/{specId3}/{specId4}/{specId5}/{specId6}", name="specs_6")
     * @Template()
     */
    public function specs6Action(Specs $specs, $specId, $specId2, $specId3, $specId4, $specId5, $specId6)
    {
        $items = $specs->listFieldInfo($specId, $specId2 . '/' . $specId3 . '/' . $specId4 . '/' . $specId5, $specId6, '../../../../../../');
        if (!$items) {
            throw $this->createNotFoundException('This specification is not found in our database');
        }
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }
       
    /**
     * @Route("/{specId}/{specId2}/{specId3}/{specId4}/{specId5}/{specId6}/{specId7}", name="specs_7")
     * @Template()
     */
    public function specs7Action(Specs $specs, $specId, $specId2, $specId3, $specId4, $specId5, $specId6, $specId7)
    {
        $items = $specs->listFieldInfo($specId, $specId2 . '/' . $specId3 . '/' . $specId4 . '/' . $specId5 . '/' . $specId6, $specId7, '../../../../../../../');
        if (!$items) {
            throw $this->createNotFoundException('This specification is not found in our database');
        }
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }
       
    /**
     * @Route("/{specId}/{specId2}/{specId3}/{specId4}/{specId5}/{specId6}/{specId7}/{specId8}", name="specs_8")
     * @Template()
     */
    public function specs8Action(Specs $specs, $specId, $specId2, $specId3, $specId4, $specId5, $specId6, $specId7, $specId8)
    {
        $items = $specs->listFieldInfo($specId, $specId2 . '/' . $specId3 . '/' . $specId4 . '/' . $specId5 . '/' . $specId6 . '/' . $specId7, $specId8, '../../../../../../../../');
        if (!$items) {
            throw $this->createNotFoundException('This specification is not found in our database');
        }
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }
}
