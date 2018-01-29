<?php

namespace RAWcookedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/RAWcooked", name="rawcooked_home")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}
