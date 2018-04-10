<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GuestRegisterFormType extends RegistrationFormType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('username')
            ->remove('name')
            ->remove('country')
            ->remove('language')
            ->remove('professional')
            ->remove('companyUrl')
            ->remove('companyName')
            ->remove('newsletter')
            ->remove('realUserName')
            ->add('email', EmailType::class, [
                'label' => 'form.email',
                'translation_domain' => 'FOSUserBundle', 'data' => null,
            ])
            ->add('username', null, [
                'label' => 'form.username',
                'translation_domain' => 'FOSUserBundle',
                'required' => false,
                'data' => null,
            ])
            ->add('name')
            ->add('country', CountryCustomType::class)
            ->add('language', LanguageCustomType::class)
            ->add('professional', ProfessionalType::class)
            ->add('companyUrl', TextType::class, array('mapped' => false, 'required' => false))
            ->add('companyName')
            ->add('newsletter')
            ->add('realUserName', HiddenType::class);
    }

    public function getParent()
    {
        return RegistrationFormType::class;
    }
}
