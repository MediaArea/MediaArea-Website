<?php

namespace OllistdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/ollistd", name="ollistd_home")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/ollistd/Contributing", name="ollistd_contributing")
     * @Template()
     */
    public function contributingAction()
    {
        return array();
    }

    /**
     * @Route("/ollistd/mp4ra_FFV1", name="ollistd_mp4ra_ffv1")
     * @Template()
     */
    public function mp4raFFV1Action()
    {
        return array();
    }

    /**
     * @Route("/ollistd/MXF_FFV1", name="ollistd_mxf_ffv1")
     * @Template()
     */
    public function mXFFFV1Action()
    {
        return array();
    }

    /**
     * @Route("/ollistd/MXF_FLAC", name="ollistd_mxf_flac")
     * @Template()
     */
    public function mXFFLACAction()
    {
        return array();
    }
}
