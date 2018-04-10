<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use UserBundle\Lib\Settings\SettingsManager;
use MediaConchOnlineBundle\Entity\DisplayFile;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyGetPoliciesNamesList;
use MediaConchOnlineBundle\Lib\MediaConch\MediaConchServerException;

class SettingsFormType extends AbstractType
{
    private $user;
    private $em;
    private $settings;
    private $policyList;

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
                'choices' => ['Last used policy' => -2] + $this->policyList,
                'placeholder' => 'No default policy',
                'required' => false,
                'label' => 'Default Policy',
                'data' => (-2 === $this->settings->getDefaultPolicy(false)) ? -2 : $this->settings->getDefaultPolicy(),
                'attr' => ['class' => 'policyList'],
            ])
            ->add('display', ChoiceType::class, [
                'choices' => ['Last used display' => -2] + $this->em->getRepository('MediaConchOnlineBundle:DisplayFile')->getUserAndSystemDisplaysChoices($this->user),
                'placeholder' => 'Default display (MediaConch Html)',
                'required' => false,
                'label' => 'Default Display',
                'data' => (-2 === $this->settings->getDefaultDisplay(false)) ? -2 : (($this->settings->getDefaultDisplay() instanceof DisplayFile) ? $this->settings->getDefaultDisplay()->getId() : $this->settings->getDefaultDisplay()),
                'attr' => ['class' => 'displayList'],
            ])
            ->add('verbosity', ChoiceType::class, [
                'choices' => [
                    'Default verbosity level (5)' => -1,
                    'Last used verbosity' => -2,
                    '0 (least verbose)' => 0,
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    '5 (most verbose)' => 5,
                ],
                'placeholder' => false,
                'required' => false,
                'label' => 'Default Verbosity',
                'data' => $this->settings->getDefaultVerbosity(false),
                'attr' => ['class' => 'verbosityList'],
            ])
            ->add('save', SubmitType::class, ['attr' => ['class' => 'btn-warning'], 'label' => 'Save settings']);
    }
}
