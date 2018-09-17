<?php

namespace PaymentBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use JMS\Payment\CoreBundle\PluginController\Event\PaymentStateChangeEvent;
use JMS\Payment\CoreBundle\Model\PaymentInterface;
use PaymentBundle\Entity\Order;
use PaymentBundle\Lib\CleanPaymentInstruction;
use PaymentBundle\Lib\CreateInvoice;
use SupportUsBundle\Lib\Individual;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Lib\DonorManipulator;

class OrdersListener
{
    protected $createInvoice;
    protected $user;
    protected $donorManipulator;
    protected $cleanPaymentInstruction;
    protected $em;

    /**
     * @param CreateInvoice         $createInvoice
     * @param TokenStorageInterface $tokenStorage
     * @param DonorManipulator      $donorManipulator
     */
    public function __construct(
        CreateInvoice $createInvoice,
        TokenStorageInterface $tokenStorage,
        DonorManipulator $donorManipulator,
        CleanPaymentInstruction $cleanPaymentInstruction,
        EntityManagerInterface $entityManager
    ) {
        $this->createInvoice = $createInvoice;
        $this->user = $tokenStorage->getToken() ? $tokenStorage->getToken()->getUser() : null;
        $this->donorManipulator = $donorManipulator;
        $this->cleanPaymentInstruction = $cleanPaymentInstruction;
        $this->em = $entityManager;
    }

    /**
     * Create invoice if payment is validated and affect donation to the user.
     *
     * @param PaymentStateChangeEvent $event Payment state change event
     */
    public function onPaymentStateChange(PaymentStateChangeEvent $event)
    {
        if (PaymentInterface::STATE_DEPOSITED === $event->getNewState()) {
            $order = $this->em->getRepository(Order::class)->findOneByPaymentInstruction(
                $event->getPayment()->getPaymentInstruction()
            );
            // Create invoice
            $this->createInvoice->create($event->getPayment()->getPaymentInstruction(), $order);

            // Add donation to user if user is connected
            if ($this->user instanceof UserInterface && 'individual' == $order->getType()) {
                $individual = new Individual();
                $votes = $individual->amountToVotes(
                    $event->getPayment()->getPaymentInstruction()->getApprovedAmount(),
                    $event->getPayment()->getPaymentInstruction()->getCurrency()
                );

                $date = $individual->amountToMembership(
                    $event->getPayment()->getPaymentInstruction()->getApprovedAmount(),
                    $event->getPayment()->getPaymentInstruction()->getCurrency()
                );

                $this->donorManipulator->addAmountVotesAndMembershipDateToUser(
                    $this->user,
                    $event->getPayment()->getPaymentInstruction()->getApprovedAmount(),
                    $votes,
                    $date
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
