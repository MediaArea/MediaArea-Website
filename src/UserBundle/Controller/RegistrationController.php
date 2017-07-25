<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RegistrationController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function registerAction(Request $request)
    {
        // Store referer
        if ('GET' == $request->getMethod() && $request->headers->get('referer') != $request->getUri()) {
            $this->get('session')->set('registerRedirect', $request->headers->get('referer'));
        }

        return parent::registerAction($request);
    }

    /**
     * {@inheritdoc}
     */
    public function confirmedAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $url = $this->get('session')->get('registerRedirect');
        if (null !== $url) {
            return $this->redirect($url);
        } else {
            return $this->render('@FOSUser/Registration/confirmed.html.twig', array(
                'user' => $user,
                'targetUrl' => $this->getTargetUrlFromSession(),
            ));
        }
    }

    /**
     * @return mixed
     */
    private function getTargetUrlFromSession()
    {
        $key = sprintf('_security.%s.target_path', $this->get('security.token_storage')->getToken()->getProviderKey());

        if ($this->get('session')->has($key)) {
            return $this->get('session')->get($key);
        }
    }
}
