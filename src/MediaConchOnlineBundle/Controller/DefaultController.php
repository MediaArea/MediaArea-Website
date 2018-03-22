<?php

namespace MediaConchOnlineBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/MediaConchOnline")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="mco_home")
     * @Template()
     */
    public function homepageAction()
    {
        return [];
    }
}
