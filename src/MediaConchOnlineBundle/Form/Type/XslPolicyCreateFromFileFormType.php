<?php

namespace MediaConchOnlineBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class XslPolicyCreateFromFileFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class, [
                'label' => 'File (max '.ini_get('upload_max_filesize').')',
                'constraints' => [new File(['maxSize' => ini_get('upload_max_filesize')])],
                'attr' => ['data-file-max-size' => ini_get('upload_max_filesize')],
            ]);
    }

    public function getBlockPrefix()
    {
        return 'xslPolicyCreateFromFile';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
