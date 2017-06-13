<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleListener implements EventSubscriberInterface
{
    protected $defaultLocale;
    protected $validLocales;

    public function __construct($defaultLocale = 'en', $validLocales = '')
    {
        $this->defaultLocale = $defaultLocale;
        $this->validLocales = explode('|', $validLocales);
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            $locale = $this->normalizeLocale($request->getPreferredLanguage(), $this->validLocales);
            $request->setLocale($locale);
            // save locale in session
            $request->getSession()->set('_locale', $locale);

            return;
        }

        // try to see if the locale has been set as a _locale routing parameter
        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $this->normalizeLocale($locale, $this->validLocales));
        } else {
            // if no explicit locale has been set on this request, use one from the session
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 15)),
        );
    }

    /**
     * Handle locale with 2 or 5 characters
     * @param string locale The locale to normalize
     * @param array validLocales The list of valid locales
     *
     * @return string
     */
    protected function normalizeLocale($locale, $validLocales)
    {
        if (in_array($locale, $validLocales)) {
            return $locale;
        }

        if (in_array(substr($locale, 0, 2), $validLocales)) {
            return substr($locale, 0, 2);
        }

        return $this->defaultLocale;
    }
}
