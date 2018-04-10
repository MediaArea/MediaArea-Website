<?php

namespace MediaConchOnlineBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class XslPolicyImportFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('policyFile', FileType::class, ['attr' => ['accept' => '.xsl,.xml']]);
    }

    public function getBlockPrefix()
    {
        return 'xslPolicyImport';
    }
}
