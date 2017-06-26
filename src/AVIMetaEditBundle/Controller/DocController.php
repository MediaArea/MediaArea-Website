<?php

namespace AVIMetaEditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DocController extends Controller
{
    /**
     * @Route("/AVIMetaEdit/tech_view_help", name="avi_doc_tech")
     * @Template()
     */
    public function techAction()
    {
        return array();
    }

    /**
     * @Route("/AVIMetaEdit/core_doc_help", name="avi_doc_core")
     * @Template()
     */
    public function coreAction()
    {
        return array();
    }

    /**
     * @Route("/AVIMetaEdit/trace", name="avi_doc_trace")
     * @Template()
     */
    public function traceAction()
    {
        return array();
    }

    /**
     * @Route("/AVIMetaEdit/errors", name="avi_doc_errors")
     * @Template()
     */
    public function errorsAction()
    {
        return array();
    }
}
