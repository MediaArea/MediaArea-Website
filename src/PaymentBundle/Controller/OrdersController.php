<?php

namespace PaymentBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\PluginController\Result;
use PaymentBundle\Entity\Order;
use PaymentBundle\Lib\IpToCurrency;

/**
 * @Route("/orders")
 */
class OrdersController extends Controller
{
    /**
     * @Route("/{id}/payment/create")
     */
    public function paymentCreateAction(Order $order)
    {
        return $this->paymentCreate(
            $order,
            $this->generateUrl('payment_orders_paymentcomplete', ['id' => $order->getId()]),
            $this->generateUrl('mi_donate')
        );
    }

    /**
     * @Route("/{id}/payment/create/individual")
     */
    public function paymentCreateIndividualAction(Order $order)
    {
        return $this->paymentCreate(
            $order,
            $this->generateUrl('payment_orders_paymentcompleteindividual', ['id' => $order->getId()]),
            $this->generateUrl('supportUs_individual')
        );
    }

    /**
     * @Route("/{id}/payment/create/corporate")
     */
    public function paymentCreateCorporateAction(Order $order)
    {
        return $this->paymentCreate(
            $order,
            $this->generateUrl('payment_orders_paymentcompletecorporate', ['id' => $order->getId()]),
            $this->generateUrl('supportUs_corporate')
        );
    }

    /**
     * @Route("/{id}/payment/create/custom")
     */
    public function paymentCreateCustomAction(Order $order, Request $request)
    {
        return $this->paymentCreate(
            $order,
            $this->generateUrl(
                'payment_orders_paymentcompletecustom',
                ['id' => $order->getId(), 'routeParams' => $request->get('routeParams', [])]
            ),
            $this->generateUrl('supportUs_custom', $request->get('routeParams', []))
        );
    }

    private function paymentCreate(Order $order, $paymentCompleteUrl, $paymentErrorReturnUrl)
    {
        $payment = $this->createPayment($order);

        $ppc = $this->get('payment.plugin_controller');
        $result = $ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());

        if (Result::STATUS_SUCCESS === $result->getStatus()) {
            return $this->redirect($paymentCompleteUrl);
        } elseif (Result::STATUS_PENDING === $result->getStatus()) {
            $exception = $result->getPluginException();

            if ($exception instanceof ActionRequiredException) {
                $action = $exception->getAction();

                if ($action instanceof VisitUrl) {
                    return $this->redirect($action->getUrl());
                }
            }
        }

        // Payment error
        $message = 'We are sorry but there is an error processing your payment';
        if ($result->getReasonCode()) {
            $errorMessage = [
                'authentication_required' => 'Your bank requires authentication, which we do not yet support',
                'approve_with_id' => 'Payment not authorized, please try again',
                'call_issuer' => 'The card has been declined',
                'card_not_supported' => 'The card does not support this type of purchase',
                'card_velocity_exceeded' => 'Credit limit exceeded',
                'do_not_honor' => 'The card has been declined',
                'do_not_try_again' => 'The card has been declined',
                'duplicate_transaction' => 'Duplicate transaction',
                'expired_card' => 'Expired card',
                'fraudulent' => 'The payment is suspected to be fraudulent',
                'incorrect_number' => 'The card number is incorrect',
                'incorrect_cvc' => 'The CVC number is incorrect',
                'invalid_cvc' => 'The CVC number is incorrect',
                'invalid_expiry_year' => 'The expiration year is invalid',
                'invalid_expiry_month' => 'The expiration month is invalid',
                'invalid_number' => 'The card number is incorrect',
                'lost_card' => 'The card is reported lost',
                'not_permitted' => 'The payment is not permitted',
                'restricted_card' => 'The card cannot be used to make this payment',
                'stolen_card' => 'The card is reported stolen',
            ];
            $message .= ' ('.($errorMessage[$result->getReasonCode()] ?? $result->getReasonCode()).')';
        }

        $message .= '.<br>';

        if ('stripe_credit_card' == $result->getPaymentInstruction()->getPaymentSystemName()) {
            $message .= 'Please use Paypal instead.<br>';
        }

        $message .= '<a href="'.$this->generateUrl('ma_contact').'">Contact us</a> if the problem persists.';

        $this->addFlash('danger', $message);

        return $this->redirect($paymentErrorReturnUrl);
    }

    /**
     * @Route("/{id}/payment/complete")
     */
    public function paymentCompleteAction(Request $request, Order $order)
    {
        return $this->paymentComplete($request, $order, $this->generateUrl('mi_donate'));
    }

    /**
     * @Route("/{id}/payment/complete/individual")
     */
    public function paymentCompleteIndividualAction(Request $request, Order $order)
    {
        return $this->paymentComplete($request, $order, $this->generateUrl('supportUs_individual'));
    }

    /**
     * @Route("/{id}/payment/complete/corporate")
     */
    public function paymentCompleteCorporateAction(Request $request, Order $order)
    {
        return $this->paymentComplete($request, $order, $this->generateUrl('supportUs_corporate'));
    }

    /**
     * @Route("/{id}/payment/complete/custom")
     */
    public function paymentCompleteCustomAction(Request $request, Order $order)
    {
        return $this->paymentComplete(
            $request,
            $order,
            $this->generateUrl('supportUs_custom', $request->get('routeParams', []))
        );
    }

    private function paymentComplete(Request $request, Order $order, $paymentErrorUrl)
    {
        // Redirect if user have already completed his payment
        if (Order::STATUS_COMPLETED === $order->getStatus()) {
            $this->addFlash('danger', 'Order already completed');

            return $this->redirect($paymentErrorUrl);
        }

        // Redirect if payment is not complete
        if ($order->getPaymentInstruction()->getAmount() !== $order->getPaymentInstruction()->getApprovedAmount()) {
            $this->addFlash('danger', 'The requested payment is not complete');

            return $this->redirect($paymentErrorUrl);
        }

        // Set order completed
        $order->setStatus(Order::STATUS_COMPLETED);
        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush($order);

        // Add flash message
        $ipToCurrency = new IpToCurrency($request->getClientIp());
        $message = sprintf(
            'Thank you, your payment of %s has been successfully processed',
            'custom' == $order->getType() ?
                (int) $order->getAmount().' '.$order->getPaymentInstruction()->getCurrency() :
                $ipToCurrency->amountWithCurrency((int) $order->getAmount())
        );

        $this->addFlash('success', $message);

        // Redirect connected users to profile page
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('fos_user_profile_show');
        }

        // Redirect anonymous users
        return $this->redirectToRoute('mi_home', ['Donated' => true]);
    }

    private function createPayment($order)
    {
        $instruction = $order->getPaymentInstruction();
        $pendingTransaction = $instruction->getPendingTransaction();

        if (null !== $pendingTransaction) {
            return $pendingTransaction->getPayment();
        }

        $ppc = $this->get('payment.plugin_controller');
        $amount = $instruction->getAmount() - $instruction->getDepositedAmount();

        return $ppc->createPayment($instruction->getId(), $amount);
    }
}
