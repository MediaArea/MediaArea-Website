<?php

namespace QCToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DocController extends Controller
{
    /**
     * @Route("/QCTools/Getting_Started", name="qc_doc_getting_started")
     * @Template()
     */
    public function gettingStartedAction()
    {
        return array();
    }

    /**
     * @Route("/QCTools/How_To_Use", name="qc_doc_how_to_use")
     * @Template()
     */
    public function howToUseAction()
    {
        return array();
    }

    /**
     * @Route("/QCTools/Filter_Descriptions", name="qc_doc_filter_descriptions")
     * @Template()
     */
    public function filterDescriptionsAction()
    {
        return array();
    }

    /**
     * @Route("/QCTools/Playback_Filters", name="qc_doc_playback_filters")
     * @Template()
     */
    public function playbackFiltersAction()
    {
        return array();
    }

    /**
     * @Route("/QCTools/Recording", name="qc_doc_recording")
     * @Template()
     */
    public function recordingAction()
    {
        return array();
    }

    /**
     * @Route("/QCTools/Seattle_Municipal_Archives_Manual", name="qc_doc_seattle")
     * @Template()
     */
    public function seattleAction()
    {
        return array();
    }
}
