<?php

namespace BWFMetaEditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DocController extends Controller
{
    /**
     * @Route("/BWFMetaEdit/tech_view_help", name="bwf_doc_tech")
     * @Template()
     */
    public function techAction()
    {
        return array();
    }

    /**
     * @Route("/BWFMetaEdit/core_doc_help", name="bwf_doc_core")
     * @Template()
     */
    public function coreAction()
    {
        return array();
    }

    /**
     * @Route("/BWFMetaEdit/trace", name="bwf_doc_trace")
     * @Template()
     */
    public function traceAction()
    {
        return array();
    }

    /**
     * @Route("/BWFMetaEdit/errors", name="bwf_doc_errors")
     * @Template()
     */
    public function errorsAction()
    {
        return array();
    }
}
