<?php

namespace DVAnalyzerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DocController extends Controller
{
    /**
     * @Route("/DVAnalyzer/dv-metadata", name="dv_doc_metadata")
     * @Template()
     */
    public function metadataAction()
    {
        return array();
    }

    /**
     * @Route("/DVAnalyzer/what-does-it-analyze", name="dv_doc_analyze")
     * @Template()
     */
    public function analyzeAction()
    {
        return array();
    }

    /**
     * @Route("/DVAnalyzer/dv-video-error-concealment", name="dv_doc_video_errors")
     * @Template()
     */
    public function videoErrorsAction()
    {
        return array();
    }

    /**
     * @Route("/DVAnalyzer/audio-errors", name="dv_doc_audio_errors")
     * @Template()
     */
    public function audioErrorsAction()
    {
        return array();
    }

    /**
     * @Route("/DVAnalyzer/dif-incoherency", name="dv_doc_dif_incoherency")
     * @Template()
     */
    public function difIncoherencyAction()
    {
        return array();
    }

    /**
     * @Route("/DVAnalyzer/stts-fluctuation", name="dv_doc_stts_fluctuation")
     * @Template()
     */
    public function sttsFluctuationAction()
    {
        return array();
    }
}
