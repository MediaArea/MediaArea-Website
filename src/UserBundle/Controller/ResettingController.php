<?php

namespace UserBundle\Controller;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use FOS\UserBundle\Controller\ResettingController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        if ($this->get('security.authorization_checker')->isGranted('ROLE_BASIC')) {
            return $this->redirectToRoute('fos_user_profile_show');
        }

        // Get request from service to keep function signature from parent controller
        $request = $this->get('request_stack')->getCurrentRequest();

        $form = $this->createRequestForm($request->query->get('email'));

        return $this->render('@FOSUser/Resetting/request.html.twig', [
            'email' => $request->query->get('email'),
            'form' => $form->createView(),
        ]);
    }

    /**
     * Request reset user password: submit form and send email.
     *
     * {@inheritdoc}
     */
    public function sendEmailAction(Request $request)
    {
        $form = $this->createRequestForm();
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('@FOSUser/Resetting/request.html.twig', [
                'email' => $request->request->get('username'),
                'form' => $form->createView(),
            ]);
        }

        return parent::sendEmailAction($request);
    }

    /**
     * Anonymous form (no name prefix) so field names stay compatible with the parent controller.
     */
    private function createRequestForm($email = null)
    {
        return $this->get('form.factory')->createNamedBuilder('', FormType::class, null, [
            'allow_extra_fields' => true,
            'csrf_protection' => false,
        ])
            ->setMethod('POST')
            ->add('username', TextType::class, [
                'label' => 'resetting.request.username',
                'translation_domain' => 'FOSUserBundle',
                'data' => $email,
                'required' => true,
            ])
            ->add('recaptcha', EWZRecaptchaType::class, [
                'attr' => [
                    'options' => [
                        'theme' => 'light',
                        'type' => 'image',
                        'size' => 'invisible',
                        'bind' => 'btn-reset-cb',
                    ],
                ],
                'mapped' => false,
                'constraints' => [
                    new RecaptchaTrue(),
                ],
            ])
            ->getForm();
    }
}
