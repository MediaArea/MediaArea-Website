<?php

namespace MediaTraceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/MediaTrace", name="mediatrace_home")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
