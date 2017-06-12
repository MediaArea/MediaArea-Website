<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaInfoSupportController extends Controller
{
    /**
     * @Route("/{_locale}/MediaInfo/Support", name="mi_support", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/{_locale}/MediaInfo/Support/FAQ", name="mi_support_faq", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function faqAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Support/Formats",
     *     name="mi_support_formats",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function formatsAction()
    {
        return array();
    }

    /**
     * @Route("/{_locale}/MediaInfo/Support/Tags", name="mi_support_tags", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function tagsAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Support/Build_From_Sources",
     *     name="mi_support_build",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function buildAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Support/Build_From_Sources/MediaInfoLib",
     *     name="mi_support_build_mil",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function buildMediaInfoLibAction()
    {
        return array();
    }
}
