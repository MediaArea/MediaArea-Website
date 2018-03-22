<?php

namespace MediaConchOnlineBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyFormFields;

class XslPolicyRuleFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, ['label' => 'Rule name', 'required' => false])

            // Standard editor
            ->add('trackType', ChoiceType::class, array(
                'placeholder' => 'Choose a track type',
                'choices' => XslPolicyFormFields::getTrackTypes(),
            ))
            ->add('field', ChoiceType::class, ['placeholder' => 'Choose a field'])
            ->add('occurrence', IntegerType::class, ['attr' => ['min' => 1], 'required' => false])
            ->add('validator', ChoiceType::class, [
                'placeholder' => false,
                'choices' => XslPolicyFormFields::getOperators(),
                'required' => false,
            ])
            ->add('value', null, ['label' => 'Content'])
            ->add('scope', HiddenType::class, ['data' => '']);

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $item = $event->getData();
            $form = $event->getForm();

            if ($item && null !== $item->getTrackType()) {
                $form->add('field', ChoiceType::class, [
                    'placeholder' => 'Choose a field',
                    'choices' => XslPolicyFormFields::getFields($item->getTrackType(), $item->getField()),
                ]);
            }
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $item = $event->getData();
            $form = $event->getForm();

            if ($item && isset($item['trackType'])) {
                $form->add('field', ChoiceType::class, [
                    'placeholder' => 'Choose a field',
                    'choices' => XslPolicyFormFields::getFields($item['trackType'], $item['field']),
                ]);
            }
        });
    }

    public function getBlockPrefix()
    {
        return 'xslPolicyRule';
    }
}
