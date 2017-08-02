<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class CountryCustomType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'preferred_choices' => array('GB', 'FR', 'DE', 'IT', 'SE', 'NL', 'BE', 'CH', 'US', 'ES'),
            'placeholder' => 'Choose your country',
            'required' => false,
        ));
    }

    public function getParent()
    {
        return CountryType::class;
    }
}
