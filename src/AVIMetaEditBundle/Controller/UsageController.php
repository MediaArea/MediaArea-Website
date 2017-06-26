<?php

namespace AVIMetaEditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UsageController extends Controller
{
    /**
     * @Route("/AVIMetaEdit/options", name="avi_usage_preferences")
     * @Template()
     */
    public function preferencesAction()
    {
        return array();
    }

    /**
     * @Route("/AVIMetaEdit/md5", name="avi_usage_md5")
     * @Template()
     */
    public function md5Action()
    {
        return array();
    }

    /**
     * @Route("/AVIMetaEdit/validation_rules_help", name="avi_usage_validation_rules")
     * @Template()
     */
    public function validationsRulesAction()
    {
        return array();
    }

    /**
     * @Route("/AVIMetaEdit/workflows", name="avi_usage_workflows")
     * @Template()
     */
    public function workflowsAction()
    {
        return array();
    }
}
