<?php

namespace PaymentBundle\Lib;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
use JMS\Payment\CoreBundle\Model\PaymentInstructionInterface;
use PaymentBundle\Entity\Invoice;
use PaymentBundle\Entity\Order;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateInvoice
{
    protected $user;
    protected $em;
    protected $request;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param EntityManager         $entityManager
     * @param RequestStack          $requestStack
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        EntityManager $entityManager,
        RequestStack $requestStack
    ) {
        $this->user = $tokenStorage->getToken() ? $tokenStorage->getToken()->getUser() : null;
        $this->em = $entityManager;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * Create an invoice record.
     *
     * @param PaymentInstructionInterface $paymentInstruction
     */
    public function create(PaymentInstructionInterface $paymentInstruction, Order $order)
    {
        // Check if user is connected
        if (!$this->user instanceof UserInterface) {
            $this->user = null;
        }

        // Get country
        $ipToCountry = new IpToCountry($this->request->getClientIp());
        $country = $ipToCountry->getCountryIsoCode('FR');

        // Calculate VAT
        $vat = new VatCalculator();
        $vat->setGross($paymentInstruction->getApprovedAmount())
            ->setCountry('custom' == $order->getType() ? 'XX' : $country)
            ->calculateNet();

        // Create invoice
        $invoice = new Invoice();
        $invoice->setUser($this->user)
            ->setPaymentInstruction($paymentInstruction)
            ->setAmount($vat->getNet())
            ->setVat($vat->getVatAmount())
            ->setCurrency($paymentInstruction->getCurrency())
            ->setIpAddress($this->request->getClientIp())
            ->setCountry($country)
            ->setDate($paymentInstruction->getUpdatedAt());

        $this->em->persist($invoice);
        $this->em->flush();
    }
}
