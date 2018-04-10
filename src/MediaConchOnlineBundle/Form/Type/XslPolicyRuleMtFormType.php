<?php

namespace MediaConchOnlineBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyFormFields;

class XslPolicyRuleMtFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, ['label' => 'Rule name', 'required' => false])
            ->add('field', TextType::class)
            ->add('validator', ChoiceType::class, [
                'placeholder' => false,
                'choices' => XslPolicyFormFields::getOperators(),
                'required' => false,
            ])
            ->add('value', TextType::class, ['required' => false])
            ->add('scope', HiddenType::class, ['data' => 'mmt']);
    }

    public function getBlockPrefix()
    {
        return 'xslPolicyRuleMt';
    }
}
