<?php

namespace VoteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Range;

class VoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('vote', IntegerType::class, [
            'attr' => $options['attr'],
            'constraints' => [
                new Type('integer'),
                new Range(['min' => $options['attr']['min'], 'max' => $options['attr']['max']]),
            ],
        ]);
    }
}
