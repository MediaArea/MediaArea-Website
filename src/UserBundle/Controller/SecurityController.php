<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function loginAction(Request $request)
    {
        // Redirect logged in user to profile page
        if ($this->get('security.authorization_checker')->isGranted('ROLE_BASIC')) {
            return $this->redirectToRoute('fos_user_profile_show');
        }

        // Store referer
        if ('GET' == $request->getMethod() && $request->headers->get('referer') != $request->getUri()) {
            $this->get('session')->set('loginRedirect', $request->headers->get('referer'));
        }

        return parent::loginAction($request);
    }
}
