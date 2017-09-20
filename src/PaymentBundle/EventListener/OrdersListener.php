<?php

namespace PaymentBundle\EventListener;

use FOS\UserBundle\Model\UserInterface;
use JMS\Payment\CoreBundle\PluginController\Event\PaymentStateChangeEvent;
use JMS\Payment\CoreBundle\Model\PaymentInterface;
use PaymentBundle\Lib\CleanPaymentInstruction;
use PaymentBundle\Lib\CreateInvoice;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Lib\DonorManipulator;

class OrdersListener
{
    protected $createInvoice;
    protected $user;
    protected $donorManipulator;
    protected $cleanPaymentInstruction;

    /**
     * @param CreateInvoice         $createInvoice
     * @param TokenStorageInterface $tokenStorage
     * @param DonorManipulator      $donorManipulator
     */
    public function __construct(
        CreateInvoice $createInvoice,
        TokenStorageInterface $tokenStorage,
        DonorManipulator $donorManipulator,
        CleanPaymentInstruction $cleanPaymentInstruction
    ) {
        $this->createInvoice = $createInvoice;
        $this->user = $tokenStorage->getToken()->getUser();
        $this->donorManipulator = $donorManipulator;
        $this->cleanPaymentInstruction = $cleanPaymentInstruction;
    }

    /**
     * Create invoice if payment is validated and affect donation to the user.
     *
     * @param PaymentStateChangeEvent $event Payment state change event
     */
    public function onPaymentStateChange(PaymentStateChangeEvent $event)
    {
        if (PaymentInterface::STATE_DEPOSITED === $event->getNewState()) {
            // Create invoice
            $this->createInvoice->create($event->getPayment()->getPaymentInstruction());

            // Add donation to user if user is connected
            if ($this->user instanceof UserInterface) {
                $this->donorManipulator->addDonationToUser(
                    $this->user,
                    $event->getPayment()->getPaymentInstruction()->getApprovedAmount()
                );
            }

            // Clean payment instruction
            $this->cleanPaymentInstruction->clean($event->getPayment()->getPaymentInstruction());
        } elseif (in_array($event->getNewState(), [
            PaymentInterface::STATE_CANCELED,
            PaymentInterface::STATE_EXPIRED,
            PaymentInterface::STATE_FAILED,
        ])) {
            // Clean payment instruction
            $this->cleanPaymentInstruction->clean($event->getPayment()->getPaymentInstruction());
        }
    }
}
