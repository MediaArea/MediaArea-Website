<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MediaInfoZZLastController extends Controller
{
    /**
     * @Route("/MediaInfo/{url}", name="mi_locale_redirect", defaults={"url": null})
     * @Route("/MediaInfo/")
     */
    public function localeRedirectAction(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        // Add locale in the url
        $url = str_replace($pathInfo, '/' . $request->getLocale() . $pathInfo, $requestUri);

        // Remove trailing slash on /MediaInfo/ request to avoid double redirect
        if ('/MediaInfo/' == substr($url, -11)) {
            $url = rtrim($url, '/');
        }

        return $this->redirect($url, 302);
    }

    /**
     * @Route("/{_locale}/MediaInfo/{url}",
     *     name="mi_unknown",
     *     requirements={"url" = ".+"},
     *     defaults={"url": null})
     * @Route("/{_locale}/MediaInfo/")
     */
    public function unknownLocaleRedirectAction(Request $request)
    {
        // Throw a 404 error if locale exists in conf (keep 302 to MI home for now)
        if (in_array($request->attributes->get('_locale'), explode('|', $this->getParameter('app.locales')))) {
            return $this->redirectToRoute('mi_home', array('_locale' => $request->getLocale()), 302);
            // throw $this->createNotFoundException('The page does not exist');
        }

        // Or redirect unknown locale to the default one
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        // Replace unknown locale by default one in the url
        $pathInfoRedir = preg_replace(
            '/^\/' . $request->attributes->get('_locale') . '\//',
            '/' . $this->getParameter('kernel.default_locale') . '/',
            $pathInfo
        );
        $url = str_replace($pathInfo, $pathInfoRedir, $requestUri);

        // Remove trailing slash on /MediaInfo/ request to avoid double redirect
        if ('/MediaInfo/' == substr($url, -11)) {
            $url = rtrim($url, '/');
        }

        return $this->redirect($url, 301);
    }

    /**
     * @Route("/MI/{url}", name="old_mi_redirect", defaults={"url": null})
     * @Route("/MI/")
     */
    public function oldMIUrlAction(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        // Add locale in the url
        $url = str_replace($pathInfo, '/' . $request->getLocale() . $pathInfo, $requestUri);

        // Replace MI by MediaInfo
        $url = str_replace('/MI', '/MediaInfo', $url);

        // Remove trailing slash on /MediaInfo/ request to avoid double redirect
        if ('/MediaInfo/' == substr($url, -11)) {
            $url = rtrim($url, '/');
        }

        return $this->redirect($url, 302);
    }

    /**
     * @Route("/{_locale}/MI/{url}", name="old_mi_locale_redirect",
     *     defaults={"url": null},
     *     requirements={"_locale": "%app.locales%"})
     * @Route("{_locale}/MI/", requirements={"_locale": "%app.locales%"})
     */
    public function oldMIUrlLocaleAction(Request $request)
    {
        $requestUri = $request->getRequestUri();

        // Replace MI by MediaInfo
        $url = str_replace('/MI', '/MediaInfo', $requestUri);

        // Remove trailing slash on /MediaInfo/ request to avoid double redirect
        if ('/MediaInfo/' == substr($url, -11)) {
            $url = rtrim($url, '/');
        }

        return $this->redirect($url, 302);
    }

    /**
     * @Route("/{url}", name="remove_trailing_slash",
     *     requirements={"url" = ".*\/$"}, methods={"GET"})
     */
    public function removeTrailingSlashAction(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);

        return $this->redirect($url, 301);
    }

    /**
     * @Route("/{url}", name="last_chance",
     *     requirements={"url" = ".+"}, methods={"GET"})
     */
    public function lastChanceAction(Request $request)
    {
        return $this->redirectToRoute('mi_home', array('_locale' => $request->getLocale()), 302);
    }
}
