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
        return ['noAds' => true];
    }

    /**
     * @Route("/NoTimeToWait1", name="notimetowait_1")
     * @Template()
     */
    public function nttw1Action()
    {
        return ['noAds' => true];
    }

    /**
     * @Route("/NoTimeToWait2", name="notimetowait_2")
     * @Template()
     */
    public function nttw2Action()
    {
        return ['noAds' => true];
    }

    /**
     * @Route("/NoTimeToWait3", name="notimetowait_3")
     * @Template()
     */
    public function nttw3Action()
    {
        return ['noAds' => true];
    }

    /**
     * @Route("/QCWorkshop2018", name="qcworkshop2018")
     * @Template()
     */
    public function qcworkshop2018Action()
    {
        return ['noAds' => true];
    }
}
