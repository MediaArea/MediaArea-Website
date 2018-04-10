<?php

namespace MediaConchOnlineBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class XslPolicyInfoFormType extends AbstractType
{
    protected $authChecker;

    public function __construct(AuthorizationCheckerInterface $authChecker)
    {
        $this->authChecker = $authChecker;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('policyName', null, ['required' => false])
            ->add('policyDescription', TextareaType::class, ['required' => false])
            ->add('policyType', ChoiceType::class, [
                'choices' => ['AND' => 'and', 'OR' => 'or'],
                'placeholder' => false,
                ])
            ->add('policyLicense', ChoiceType::class, [
                'choices' => [
                    'Creative Commons Zero' => 'CC0-1.0+',
                    'Creative Commons Attribution' => 'CC-BY-4.0+',
                    'Creative Commons Attribution-ShareAlike' => 'CC-BY-SA-4.0+',
                    'Other' => '',
                ],
                'placeholder' => false,
                ])
            ->add('policyTopLevel', HiddenType::class);

        if ($this->authChecker->isGranted('ROLE_BASIC')) {
            $builder->add('policyVisibility', ChoiceType::class, [
                'choices' => ['Private' => false, 'Public' => true],
                'placeholder' => false,
            ]);
        }
    }

    public function getBlockPrefix()
    {
        return 'xslPolicyInfo';
    }
}
