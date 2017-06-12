<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class CookiesListener
{
    /**
     * @param GetResponseEvent $event
     */
    public function handleCookies(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (null !== $request->cookies->get('Donated')) {
            $event->getRequest()->attributes->set('donated', $request->cookies->get('Donated'));
        }
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function setCookies(FilterResponseEvent $event)
    {
        // Check if donated cookie attribute has been set and add cookie to response
        if (null !== $cookie = $event->getRequest()->attributes->get('setDonatedCookie')) {
            $cookie = new Cookie('Donated', $cookie, '+5 years');
            $event->getResponse()->headers->setCookie($cookie);
        }
    }
}
