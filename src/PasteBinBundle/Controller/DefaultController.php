<?php

namespace PasteBinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PasteBinBundle\Entity\Paste;

/**
 * @Security("has_role('ROLE_BETA')")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/p", name="pastebin_home")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/p/{id}", name="pastebin_show")
     * @Template()
     */
    public function showAction(Paste $paste)
    {
        $xml = file_get_contents('/dev/shm/'.$paste->getId().'.xml');

        return ['paste' => $paste, 'xml' => $xml];
    }
}
