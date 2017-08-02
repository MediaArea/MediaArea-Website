<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\ResettingController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller managing the resetting of the password.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class ResettingController extends BaseController
{
    /**
     * Request reset user password: show form.
     */
    public function requestAction()
    {
        // Redirect logged in user to profile page
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('fos_user_profile_show');
        }

        // Get request from service to keep function signature from parent controller
        $request = $this->get('request_stack')->getCurrentRequest();

        return $this->render('@FOSUser/Resetting/request.html.twig', array('email' => $request->query->get('email')));
    }
}
