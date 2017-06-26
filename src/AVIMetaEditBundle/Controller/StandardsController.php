<?php

namespace AVIMetaEditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StandardsController extends Controller
{
    /**
     * @Route("/AVIMetaEdit/listinfo", name="avi_standards_listinfo")
     * @Template()
     */
    public function listinfoAction()
    {
        return array();
    }

    /**
     * @Route("/AVIMetaEdit/imit", name="avi_standards_imit")
     * @Template()
     */
    public function imitAction()
    {
        return array();
    }

    /**
     * @Route("/AVIMetaEdit/xml_chunks", name="avi_standards_xml_chunks")
     * @Template()
     */
    public function xmlChunksAction()
    {
        return array();
    }
}
