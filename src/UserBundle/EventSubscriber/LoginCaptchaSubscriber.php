<?php

namespace UserBundle\EventSubscriber;

use ReCaptcha\ReCaptcha;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;

class LoginCaptchaSubscriber implements EventSubscriberInterface
{
    private $privateKey;
    private $router;

    public function __construct($privateKey, RouterInterface $router)
    {
        $this->privateKey = $privateKey;
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

        if ($request->attributes->get('_login_captcha_checked')) {
            return;
        }
        $request->attributes->set('_login_captcha_checked', true);

        $recaptcha = new ReCaptcha($this->privateKey);
        $recaptcha->setExpectedHostname($request->getHost());
        $response = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());

        if ($response->isSuccess()) {
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
