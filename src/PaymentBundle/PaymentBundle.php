<?php

namespace PaymentBundle;

use PaymentBundle\DependencyInjection\Compiler\AddPaymentMethodFormTypesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PaymentBundle extends Bundle
{
    public function build(ContainerBuilder $builder)
    {
        parent::build($builder);

        $builder->addCompilerPass(new AddPaymentMethodFormTypesPass());
    }
}
