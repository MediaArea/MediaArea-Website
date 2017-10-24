<?php

namespace SupportUsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use PaymentBundle\Entity\Order;
use PaymentBundle\Form\ChoosePaymentMethodType;
use PaymentBundle\Lib\IpToCountry;
use PaymentBundle\Lib\IpToCurrency;
use PaymentBundle\Lib\VatCalculator;
use SupportUsBundle\Lib\Corporate;
use SupportUsBundle\Lib\Individual;

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

        if ('POST' === $request->getMethod() &&
            null !== $payment = $request->request->get('ma_choose_payment_method')) {
            $amount = $payment['amount'];
            if (!is_numeric($amount) || $amount < 1) {
                throw new \Exception('Error Processing Request', 1);
            }

            $em = $this->getDoctrine()->getManager();
            $order = new Order($amount);
            $em->persist($order);
            $em->flush($order);

            $returnUrl = $this->generateUrl(
                'payment_orders_paymentcreateindividual',
                ['id' => $order->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
            $cancerlUrl = $this->generateUrl('supportUs_individual', [], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        $form = $this->createForm(ChoosePaymentMethodType::class, null, [
            'amount_field_type' => 'text',
            'amount' => $amount ?? 1,
            'currency' => $ipToCurrency->getCurrency(),
            'default_method' => 'stripe_credit_card',
            'predefined_data' => [
                'adyen_credit_card' => [
                    'return_url' => $returnUrl ?? '',
                ],
                'paypal_express_checkout' => [
                    'return_url' => $returnUrl ?? '',
                    'cancel_url' => $cancerlUrl ?? '',
                    'useraction' => 'commit',
                ],
            ],
            'method_options' => [
                'paypal_express_checkout' => [
                    'label' => false,
                ],
                'stripe_credit_card' => [
                    'data' => ['name' => (null !== $this->getUser()) ? $this->getUser()->getNameForDisplay() : ''],
                ],
            ],
            'allowed_methods' => ['paypal_express_checkout', 'stripe_credit_card'],
        ]);

        $form->handleRequest($request);

        if ('POST' === $request->getMethod() && $form->isSubmitted() && $form->isValid()) {
            $ppc = $this->get('payment.plugin_controller');
            $ppc->createPaymentInstruction($instruction = $form->getData());

            $order->setPaymentInstruction($instruction);
            $em->persist($order);
            $em->flush($order);

            return $this->redirect($this->generateUrl('payment_orders_paymentcreateindividual', [
                'id' => $order->getId(),
            ]));
        }

        return [
            'noAds' => true,
            'country' => $ipToCountry,
            'currency' => $ipToCurrency,
            'vatRate' => $vat->getVatRate(),
            'form' => $form->createView(),
            'individual' => new Individual(),
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
            'corporate' => new Corporate(),
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
