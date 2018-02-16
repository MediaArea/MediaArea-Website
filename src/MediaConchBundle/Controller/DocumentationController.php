<?php

namespace MediaConchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/MediaConch/Documentation/")
 */
class DocumentationController extends Controller
{
    /**
     * @Route("Fixity", name="mc_documentation_fixity")
     * @Template()
     */
    public function fixityAction()
    {
        return [];
    }

    /**
     * @Route("FAQ", name="mc_documentation_faq")
     * @Template()
     */
    public function faqAction()
    {
        return [];
    }

    /**
     * @Route("HowToUse", name="mc_documentation_howtouse")
     * @Template()
     */
    public function howToUseAction()
    {
        return [];
    }

    /**
     * @Route("DataFormat", name="mc_documentation_dataformat")
     * @Template()
     */
    public function dataFormatAction()
    {
        return [];
    }

    /**
     * @Route("Installation", name="mc_documentation_installation")
     * @Template()
     */
    public function installationAction()
    {
        return [];
    }
}
