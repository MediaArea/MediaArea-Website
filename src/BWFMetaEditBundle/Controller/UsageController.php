<?php

namespace BWFMetaEditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UsageController extends Controller
{
    /**
     * @Route("/BWFMetaEdit/options", name="bwf_usage_preferences")
     * @Template()
     */
    public function preferencesAction()
    {
        return array();
    }

    /**
     * @Route("/BWFMetaEdit/md5", name="bwf_usage_md5")
     * @Template()
     */
    public function md5Action()
    {
        return array();
    }

    /**
     * @Route("/BWFMetaEdit/validation_rules_help", name="bwf_usage_validation_rules")
     * @Template()
     */
    public function validationsRulesAction()
    {
        return array();
    }

    /**
     * @Route("/BWFMetaEdit/workflows", name="bwf_usage_workflows")
     * @Template()
     */
    public function workflowsAction()
    {
        return array();
    }
}
