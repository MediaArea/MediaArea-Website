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
        $payment = $this->createPayment($order);

        $ppc = $this->get('payment.plugin_controller');
        $result = $ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());

        if ($result->getStatus() === Result::STATUS_SUCCESS) {
            return $this->redirect($this->generateUrl('payment_orders_paymentcomplete', [
                'id' => $order->getId(),
            ]));
        } elseif ($result->getStatus() === Result::STATUS_PENDING) {
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
            $message .= ' ('.$result->getReasonCode().')';
        }

        $message .= '.<br>';

        if ('stripe_credit_card' == $result->getPaymentInstruction()->getPaymentSystemName()) {
            $message .= 'You may also consider to pay with Paypal by credit card.<br>';
        }

        $message .= '<a href="mailto:info@mediaarea.net">Contact us</a> if the problem persists.';

        $this->addFlash('danger', $message);

        return $this->redirectToRoute('mi_donate');
    }

    /**
     * @Route("/{id}/payment/complete")
     */
    public function paymentCompleteAction(Request $request, Order $order)
    {
        $ipToCurrency = new IpToCurrency($request->getClientIp());
        $message = sprintf(
            'Thank you, your payment of %s have been successfully processed',
            $ipToCurrency->amountWithCurrency((int) $order->getAmount())
        );

        $this->addFlash(
            'success',
            $message
        );

        // Redirect connected users to profile page
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('fos_user_profile_show');
        }

        return $this->redirectToRoute('mi_home', ['Donated' => true]);
    }

    private function createPayment($order)
    {
        $instruction = $order->getPaymentInstruction();
        $pendingTransaction = $instruction->getPendingTransaction();

        if ($pendingTransaction !== null) {
            return $pendingTransaction->getPayment();
        }

        $ppc = $this->get('payment.plugin_controller');
        $amount = $instruction->getAmount() - $instruction->getDepositedAmount();

        return $ppc->createPayment($instruction->getId(), $amount);
    }
}
