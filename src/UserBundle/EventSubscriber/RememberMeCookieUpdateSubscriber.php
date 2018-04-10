<?php

namespace UserBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\RememberMe\RememberMeServicesInterface;

class RememberMeCookieUpdateSubscriber implements EventSubscriberInterface
{
    protected $tokenStorage;
    protected $rememberMeServices;

    public function __construct(TokenStorageInterface $tokenStorage, RememberMeServicesInterface $rememberMeServices)
    {
        $this->tokenStorage = $tokenStorage;
        $this->rememberMeServices = $rememberMeServices;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
            KernelEvents::RESPONSE => 'rememberMeUpdateCookie',
        );
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        // Set remember_me attribute to add cookie in response
        $event->getRequest()->attributes->set('remember_me_update_cookie', true);

        // Set guest cookie attribute to add cookie in response if user is a guest
        $user = $this->tokenStorage->getToken()->getUser();
        if ($user->hasRole('ROLE_GUEST')) {
            // Only for guest users created after guestToken have been used
            if (null !== $user->getGuestToken()) {
                $event->getRequest()->attributes->set('guest_cookie', $user->getUsername().':'.$user->getGuestToken()->getToken());
            }
        }
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function rememberMeUpdateCookie(FilterResponseEvent $event)
    {
        // Check if remember_me update attribute has been set and add cookie to response
        if (true === $event->getRequest()->attributes->get('remember_me_update_cookie')) {
            // Force _remember_me value to yes
            $event->getRequest()->query->set('_remember_me', 'yes');

            // Set rememberme cookie by calling loginSuccess
            $this->rememberMeServices->loginSuccess($event->getRequest(), $event->getResponse(), $this->tokenStorage->getToken());
        }
    }
}
