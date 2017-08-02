<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProfileFormType extends AbstractType
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
            ->add('companyName')
            ->add('newsletter');

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();

            if (null !== $user && 0 == $user->getRealUserName()) {
                $form->add('oldname', HiddenType::class, array('mapped' => false, 'data' => $user->getUsername()));
                $user->setUsername(null);
                $event->setData($user);
            }
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();

            if ($form->isValid() && null !== $user) {
                // User have random username
                if (0 == $user->getRealUsername()) {
                    // User do not have fill his username
                    if (null === $user->getUsername()) {
                        $user->setUsername($form['oldname']->getData());
                    } else {
                        // User have fill his username
                        $user->setRealUserName(1);
                    }
                    $event->setData($user);
                } elseif (null === $user->getUsername()) {
                    // User have remove his username
                    $user->setUsername(uniqid());
                    $user->setRealUserName(0);
                    $event->setData($user);
                }
            }
        });
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}
