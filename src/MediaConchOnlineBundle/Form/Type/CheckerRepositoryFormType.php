<?php

namespace MediaConchOnlineBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CheckerRepositoryFormType extends CheckerBaseFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('check', SubmitType::class, ['attr' => ['class' => 'btn-warning'], 'label' => 'Check files']);
    }

    public function getBlockPrefix()
    {
        return 'checkerRepository';
    }
}
