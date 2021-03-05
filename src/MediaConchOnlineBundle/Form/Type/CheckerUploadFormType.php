<?php

namespace MediaConchOnlineBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CheckerUploadFormType extends CheckerBaseFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('file', FileType::class, [
                'label' => 'File (max '.ini_get('upload_max_filesize').')',
                'constraints' => [new File(['maxSize' => ini_get('upload_max_filesize')])],
                'attr' => ['data-file-max-size' => ini_get('upload_max_filesize')],
            ])
            ->add('check', SubmitType::class, ['attr' => ['class' => 'btn-warning'], 'label' => 'Check file']);
    }

    public function getBlockPrefix()
    {
        return 'checkerUpload';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
