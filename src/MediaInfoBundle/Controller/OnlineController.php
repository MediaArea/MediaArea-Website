<?php

namespace MediaInfoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OnlineController extends Controller
{
    /**
     * @Route("/MediaInfoOnline", name="mi_online")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}
