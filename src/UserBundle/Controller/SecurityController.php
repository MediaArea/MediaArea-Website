<?php

namespace UserBundle\Controller;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
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

    protected function renderLogin(array $data)
    {
        $form = $this->get('form.factory')->createNamed('', FormType::class, null, [
            'csrf_protection' => false,
        ]);
        $form->add('recaptcha', EWZRecaptchaType::class, [
            'attr' => [
                'options' => [
                    'theme' => 'light',
                    'type' => 'image',
                    'size' => 'invisible',
                    'bind' => 'btn-login-cb',
                ],
            ],
            'mapped' => false,
            'constraints' => [
                new RecaptchaTrue(),
            ],
        ]);

        $data['captcha_form'] = $form->createView();

        return $this->render('@FOSUser/Security/login.html.twig', $data);
    }
}
