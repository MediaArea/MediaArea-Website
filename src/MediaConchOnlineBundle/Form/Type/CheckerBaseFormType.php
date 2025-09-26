<?php

namespace MediaConchOnlineBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use UserBundle\Lib\Settings\SettingsManager;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyGetPoliciesNamesList;
use MediaConchOnlineBundle\Lib\MediaConch\MediaConchServerException;

class CheckerBaseFormType extends AbstractType
{
    protected $user;
    protected $em;
    protected $settings;
    protected $policyList;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        EntityManagerInterface $em,
        SettingsManager $settings,
        XslPolicyGetPoliciesNamesList $policyList
    ) {
        $token = $tokenStorage->getToken();
        if (null !== $token && $token->getUser() instanceof UserInterface) {
            $this->user = $token->getUser();
        } else {
            throw new \Exception('Invalid User');
        }

        $this->em = $em;
        $this->settings = $settings;

        try {
            $this->policyList = $policyList;
            $this->policyList->getPoliciesNamesList();
            $this->policyList = $this->policyList->getListForChoiceForm();
        } catch (MediaConchServerException $e) {
            $this->policyList = [];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('policy', ChoiceType::class, [
                'choices' => $this->policyList,
                'placeholder' => 'Choose a policy',
                'required' => false,
                'label' => 'Policy',
                'data' => $this->settings->getDefaultPolicy(),
                'attr' => ['class' => 'policyList'],
            ])
            ->add('display', EntityType::class, [
                'class' => 'MediaConchOnlineBundle:DisplayFile',
                'choices' => $this->em->getRepository('MediaConchOnlineBundle:DisplayFile')->getUserAndSystemDisplays($this->user),
                'placeholder' => 'Choose a display',
                'required' => false,
                'label' => 'Display',
                'data' => $this->settings->getDefaultDisplay(),
                'attr' => ['class' => 'displayList'],
            ])
            ->add('verbosity', ChoiceType::class, [
                'choices' => [
                    'Default level (5)' => -1,
                    '0 (least verbose)' => 0,
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    '5 (most verbose)' => 5,
                    ],
                'placeholder' => false,
                'required' => false,
                'label' => 'Verbosity',
                'data' => $this->settings->getDefaultVerbosity(),
                'attr' => ['class' => 'verbosityList'],
            ]);
    }

    public function getBlockPrefix()
    {
        return 'form';
    }
}
