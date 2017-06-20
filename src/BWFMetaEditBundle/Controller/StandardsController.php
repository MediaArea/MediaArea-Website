<?php

namespace BWFMetaEditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StandardsController extends Controller
{
    /**
     * @Route("/BWFMetaEdit/bext", name="bwf_standards_bext")
     * @Template()
     */
    public function bextAction()
    {
        return array();
    }

    /**
     * @Route("/BWFMetaEdit/listinfo", name="bwf_standards_listinfo")
     * @Template()
     */
    public function listinfoAction()
    {
        return array();
    }

    /**
     * @Route("/BWFMetaEdit/xml_chunks", name="bwf_standards_xml_chunks")
     * @Template()
     */
    public function xmlChunksAction()
    {
        return array();
    }
}
