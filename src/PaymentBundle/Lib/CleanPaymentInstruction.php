<?php

namespace PaymentBundle\Lib;

use Doctrine\ORM\EntityManager;
use JMS\Payment\CoreBundle\Model\PaymentInstructionInterface;

class CleanPaymentInstruction
{
    protected $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Clean a payment instruction.
     *
     * @param PaymentInstructionInterface $paymentInstruction
     */
    public function clean(PaymentInstructionInterface $paymentInstruction)
    {
        if ('stripe_credit_card' == $paymentInstruction->getPaymentSystemName()) {
            $this->cleanStripeCreditCard($paymentInstruction);
        }
    }

    /**
     * Clean stripe credit card payment instruction.
     *
     * @param PaymentInstructionInterface $paymentInstruction
     */
    protected function cleanStripeCreditCard(PaymentInstructionInterface $paymentInstruction)
    {
        $paymentInstruction->getExtendedData()->remove('number');
        $paymentInstruction->getExtendedData()->remove('exp_month');
        $paymentInstruction->getExtendedData()->remove('exp_year');
        $paymentInstruction->getExtendedData()->remove('cvc');
        $paymentInstruction->setCreditedAmount(0);

        $this->em->persist($paymentInstruction);
        $this->em->flush();
    }
}
