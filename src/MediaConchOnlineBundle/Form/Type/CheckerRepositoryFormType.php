<?php

namespace MediaConchOnlineBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
