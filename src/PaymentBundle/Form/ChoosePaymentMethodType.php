<?php

namespace PaymentBundle\Form;

use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType as BaseType;
use JMS\Payment\CoreBundle\PluginController\PluginControllerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
        if ('text' == $options['amount_field_type']) {
            $builder->add('amount', TextType::class, [
                'mapped' => false,
                'data' => $options['amount'],
            ]);
        } else {
            $builder->add('amount', ChoiceType::class, [
                'mapped' => false,
                'choices' => $ipToCurrency->getAmountChoices(),
                'data' => $ipToCurrency->getAmountDefault(),
            ]);
        }

        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'amount_field_type' => 'list',
        ));
        $resolver->addAllowedTypes('amount_field_type', 'string');
        parent::configureOptions($resolver);
    }

    public function getBlockPrefix()
    {
        return 'ma_choose_payment_method';
    }
}
