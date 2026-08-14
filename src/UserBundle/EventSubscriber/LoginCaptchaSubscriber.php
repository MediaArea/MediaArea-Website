<?php

namespace UserBundle\EventSubscriber;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;

class LoginCaptchaSubscriber implements EventSubscriberInterface
{
    private $formFactory;
    private $router;

    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 10],
        ];
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        if ('POST' !== $request->getMethod() || 'fos_user_security_check' !== $request->attributes->get('_route')) {
            return;
        }

        $form = $this->formFactory->createNamed('', FormType::class, null, [
            'allow_extra_fields' => true,
            'csrf_protection' => false,
        ]);
        $form->add('recaptcha', EWZRecaptchaType::class, [
            'mapped' => false,
            'constraints' => [
                new RecaptchaTrue(),
            ],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return;
        }

        $session = $request->getSession();
        $session->set(Security::LAST_USERNAME, $request->request->get('_username', ''));
        $session->set(
            Security::AUTHENTICATION_ERROR,
            new CustomUserMessageAuthenticationException('This value is not a valid captcha.')
        );

        $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
    }
}
