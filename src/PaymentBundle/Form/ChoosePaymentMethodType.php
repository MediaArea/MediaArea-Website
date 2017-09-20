<?php

namespace PaymentBundle\Form;

use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType as BaseType;
use JMS\Payment\CoreBundle\PluginController\PluginControllerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;

use PaymentBundle\Lib\IpToCurrency;

class ChoosePaymentMethodType extends BaseType
{
    protected $request;

    public function __construct(
        PluginControllerInterface $pluginController,
        RequestStack $requestStack,
        array $paymentMethods
    ) {
        parent::__construct($pluginController, $paymentMethods);
        $this->request = $requestStack->getCurrentRequest();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $ipToCurrency = new IpToCurrency($this->request->getClientIp());
        $builder->add('amount', ChoiceType::class, [
            'mapped' => false,
            'choices' => $ipToCurrency->getAmountChoices(),
            'data' => $ipToCurrency->getAmountDefault(),
        ]);
        parent::buildForm($builder, $options);
    }

    public function getBlockPrefix()
    {
        return 'ma_choose_payment_method';
    }
}
