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
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $type;

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
     * Set type.
     *
     * @param string|null $type
     *
     * @return Order
     */
    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status.
     *
     * @param int $status
     *
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set paymentInstruction.
     *
     * @param \JMS\Payment\CoreBundle\Entity\PaymentInstruction|null $paymentInstruction
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
     * @return \JMS\Payment\CoreBundle\Entity\PaymentInstruction|null
     */
    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }
}
