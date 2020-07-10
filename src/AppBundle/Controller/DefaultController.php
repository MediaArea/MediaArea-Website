<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        //return $this->redirectToRoute('mi_home', array('_locale' => substr($request->getLocale(), 0, 2)));
        return ['noAds' => true];
    }

    /**
     * @Route("/{_locale}/Repos", name="ma_repos", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function reposAction()
    {
        return [];
    }

    /**
     * @Route("/Repos", name="ma_repos_wo_locale")
     */
    public function reposActionWithoutLocale(Request $request)
    {
        return $this->redirectToRoute('ma_repos', ['_locale' => $request->getLocale()], 302);
    }

    /**
     * @Route("/Events", name="ma_events")
     * @Template()
     */
    public function eventsAction()
    {
        return ['noAds' => true];
    }

    /**
     * @Route("/Conduct", name="ma_conduct")
     * @Template()
     */
    public function conductAction()
    {
        return ['noAds' => true];
    }

    /**
     * @Route("/TeamRules", name="ma_team_rules")
     * @Template()
     */
    public function teamRulesAction()
    {
        return [];
    }

    /**
     * @Route("/Legal", name="ma_legal")
     * @Template()
     */
    public function legalAction()
    {
        return [];
    }

    /**
     * @Route("/{_locale}/DIVX", name="ma_divx", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function divxAction()
    {
        return [];
    }

    /**
     * @Route("/{_locale}/DX50", name="ma_dx50", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function dx50Action()
    {
        return [];
    }

    /**
     * @Route("/{_locale}/XVID", name="ma_xvid", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function xvidAction()
    {
        return [];
    }

    /**
     * @Route("/Services", name="ma_professional_services")
     * @Template()
     */
    public function professionalServicesAction()
    {
        return ['noAds' => true];
    }

    /**
     * @Route("/Privacy", name="ma_privacy")
     * @Template()
     */
    public function privacyAction()
    {
        return ['noAds' => true];
    }

    /**
     * @Route("/AudioChannelLayout", name="ma_audiochannellayout")
     * @Template()
     */
    public function audioChannelLayoutAction()
    {
        return ['noAds' => true];
    }
}
