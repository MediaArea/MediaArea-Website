<?php

namespace PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="orders")
 * @ORM\Entity
 */
class Order
{
    const STATUS_NEW = 0;
    const STATUS_COMPLETED = 1;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction")
     */
    private $paymentInstruction;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    private $amount;

    /**
     * @ORM\Column(type="smallint", nullable=false, options={"default":0})
     */
    protected $status = 0;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount.
     *
     * @param string $amount
     *
     * @return Order
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set paymentInstruction.
     *
     * @param \JMS\Payment\CoreBundle\Entity\PaymentInstruction $paymentInstruction
     *
     * @return Order
     */
    public function setPaymentInstruction(\JMS\Payment\CoreBundle\Entity\PaymentInstruction $paymentInstruction = null)
    {
        $this->paymentInstruction = $paymentInstruction;

        return $this;
    }

    /**
     * Get paymentInstruction.
     *
     * @return \JMS\Payment\CoreBundle\Entity\PaymentInstruction
     */
    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }
}
