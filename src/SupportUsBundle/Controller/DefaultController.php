<?php

namespace SupportUsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use PaymentBundle\Lib\IpToCountry;
use PaymentBundle\Lib\IpToCurrency;
use PaymentBundle\Lib\VatCalculator;

/**
 * @Security("has_role('ROLE_BETA')")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/SupportUs", name="supportUs_about")
     * @Template()
     */
    public function aboutAction()
    {
        return ['noAds' => true];
    }

    /**
     * @Route("/SupportUs/Individual", name="supportUs_individual")
     * @Template()
     */
    public function individualAction(Request $request)
    {
        $ipToCurrency = new IpToCurrency($request->getClientIp());
        $ipToCountry = new IpToCountry($request->getClientIp());
        $vat = new VatCalculator();
        $vat->setCountry($ipToCountry->getCountryIsoCode('FR'));

        return [
            'noAds' => true,
            'country' => $ipToCountry->getCountryName(false),
            'currency' => $ipToCurrency,
            'vatRate' => $vat->getVatRate(),
        ];
    }

    /**
     * @Route("/SupportUs/Corporate", name="supportUs_corporate")
     * @Template()
     */
    public function corporateAction(Request $request)
    {
        $ipToCurrency = new IpToCurrency($request->getClientIp());
        $ipToCountry = new IpToCountry($request->getClientIp());

        return [
            'noAds' => true,
            'country' => $ipToCountry->getCountryName(false),
            'currency' => $ipToCurrency,
        ];
    }

    /**
     * @Route("/SupportUs/FAQ", name="supportUs_faq")
     * @Template()
     */
    public function faqAction()
    {
        return ['noAds' => true];
    }

    /**
     * @Route("/SupportUs/Sponsors", name="supportUs_sponsors_list")
     * @Template()
     */
    public function sponsorsListAction()
    {
        return ['noAds' => true];
    }

    /**
     * @Route("/SupportUs/Supporters", name="supportUs_supporters_list")
     * @Template()
     */
    public function supportersListAction()
    {
        return ['noAds' => true];
    }
}
