<?php

namespace MediaInfoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CompareController extends Controller
{
    /**
     * @Route("/MediaCompare", name="mi_compare")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}
