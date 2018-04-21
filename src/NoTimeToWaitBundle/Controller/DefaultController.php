<?php

namespace NoTimeToWaitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/NoTimeToWait", name="notimetowait_home")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/NoTimeToWait1", name="notimetowait_1")
     * @Template()
     */
    public function nttw1Action()
    {
        return [];
    }

    /**
     * @Route("/NoTimeToWait2", name="notimetowait_2")
     * @Template()
     */
    public function nttw2Action()
    {
        return [];
    }

    /**
     * @Route("/NoTimeToWait3", name="notimetowait_3")
     * @Template()
     */
    public function nttw3Action()
    {
        return [];
    }
}
