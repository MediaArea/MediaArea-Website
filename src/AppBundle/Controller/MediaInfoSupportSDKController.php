<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaInfoSupportSDKController extends Controller
{
    /**
     * @Route("/{_locale}/MediaInfo/Support/SDK", name="mi_support_sdk", requirements={"_locale": "%app.locales%"})
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Support/SDK/ReadFirst",
     *     name="mi_support_sdk_readfirst",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function readFirstAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Support/SDK/Means",
     *     name="mi_support_sdk_means",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function meansAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Support/SDK/Quick_Start",
     *     name="mi_support_sdk_quick_start",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function quickStartAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Support/SDK/More_Info",
     *     name="mi_support_sdk_more_info",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function moreInfoAction()
    {
        return array();
    }
    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Support/SDK/Buffers",
     *     name="mi_support_sdk_buffers",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function buffersAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Support/SDK/Duplicate",
     *     name="mi_support_sdk_duplicate",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function duplicateAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/{_locale}/MediaInfo/Support/SDK/Filtering",
     *     name="mi_support_sdk_filtering",
     *     requirements={"_locale": "%app.locales%"
     *     }
     * )
     * @Template()
     */
    public function filteringAction()
    {
        return array();
    }
}
