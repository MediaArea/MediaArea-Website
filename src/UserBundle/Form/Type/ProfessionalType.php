<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfessionalType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                'Yes' => 1,
                'No' => 0,
            ),
            'placeholder' => 'Not specified',
            'required' => false,
        ));
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
