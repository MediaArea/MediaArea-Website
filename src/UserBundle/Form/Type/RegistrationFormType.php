<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RegistrationFormType extends AbstractType
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('username')
            ->add('username', null, array(
                'label' => 'form.username',
                'translation_domain' => 'FOSUserBundle',
                'required' => false,
            ))
            ->add('name')
            ->add('country', CountryCustomType::class)
            ->add('language', LanguageCustomType::class)
            ->add('professional', ProfessionalType::class)
            ->add('companyUrl', TextType::class, array('mapped' => false, 'required' => false))
            ->add('companyName')
            ->add('newsletter')
            ->add('realUserName', HiddenType::class);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if (!isset($data['companyUrl']) || !empty($data['companyUrl'])) {
                $form->addError(new FormError('Company URL error'));
            }
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();

            if ($form->isValid() && null !== $user && null === $user->getUsername()) {
                $user->setUsername(uniqid());
                $user->setRealUserName(0);
                $event->setData($user);
            }
        });
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}
