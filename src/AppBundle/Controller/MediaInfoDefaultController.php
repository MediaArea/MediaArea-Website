<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaInfoDefaultController extends Controller
{
    /**
     * @Route("/{_locale}/MediaInfo", name="mi_home", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function aboutAction(Request $request)
    {
        // Donated request
        if (null !== $request->query->get('Donated')) {
            $request->attributes->set('setDonatedCookie', 'Y');
            return $this->redirectToRoute('mi_home', array('_locale' => $request->getLocale()), 302);
        }

        // New version request (increment counter if not a donor)
        if (null !== $request->query->get('NewVersionRequested')) {
            if ('Y' != $request->attributes->get('donated')) {
                if (ctype_digit($request->attributes->get('donated'))) {
                    $request->attributes->set('setDonatedCookie', $request->attributes->get('donated') + 1);
                } else {
                    $request->attributes->set('setDonatedCookie', 1);
                }
            }

            return $this->redirectToRoute('mi_home', array('_locale' => $request->getLocale()), 302);
        }

        // Download infos
        $downloadInfo = $this->get('app.download_info');
        $downloadInfo->setUserAgent($request->headers->get('User-Agent'));
        $downloadInfo->parse();

        // RTL header
        if ('fa' == $request->getLocale()) {
            $rtl = true;
        }

        return array(
            'downloadInfo' => $downloadInfo,
            'rtl' => isset($rtl),
        );
    }

    /**
     * @Route("/{_locale}/MediaInfo/Screenshots", name="mi_screenshots", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function screenshotsAction()
    {
        return array();
    }

    /**
     * @Route("/{_locale}/MediaInfo/Donate", name="mi_donate", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function donateAction()
    {
        return array('noAds' => true);
    }

    /**
     * @Route("/{_locale}/MediaInfo/Testimonials", name="mi_testimonials", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function testimonialsAction()
    {
        return array('noAds' => true);
    }

    /**
     * @Route("/{_locale}/MediaInfo/License", name="mi_license", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function licenseAction()
    {
        return array();
    }

    /**
     * @Route("/{_locale}/MediaInfo/Prices", name="mi_prices", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function pricesAction()
    {
        return array('noAds' => true);
    }

    /**
     * @Route("/{_locale}/MediaInfo/Bundled", name="mi_bundled", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function bundledAction()
    {
        return array();
    }

    /**
     * @Route("/MediaInfo/ChangeLog", name="mi_changelog")
     * @Template()
     */
    public function changelogAction()
    {
        return array();
    }
}
