<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        //return $this->redirectToRoute('mi_home', array('_locale' => substr($request->getLocale(), 0, 2)));
        return array('noAds' => true);
    }

    /**
     * @Route("/{_locale}/Repos", name="ma_repos", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function reposAction()
    {
        return array();
    }

    /**
     * @Route("/Events", name="ma_events")
     * @Template()
     */
    public function eventsAction()
    {
        return array('noAds' => true);
    }

    /**
     * @Route("/Legal", name="ma_legal")
     * @Template()
     */
    public function legalAction()
    {
        return array();
    }

    /**
     * @Route("/{_locale}/DIVX", name="ma_divx", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function divxAction()
    {
        return array();
    }

    /**
     * @Route("/{_locale}/DX50", name="ma_dx50", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function dx50Action()
    {
        return array();
    }

    /**
     * @Route("/{_locale}/XVID", name="ma_xvid", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function xvidAction()
    {
        return array();
    }
}
