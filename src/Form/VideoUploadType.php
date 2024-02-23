<?php
// src/Form/VideoUploadType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class VideoUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('video', FileType::class, [
                'label' => 'Video (MP4 file)',
                'mapped' => false, // This field is not associated with any entity property
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1000000024K',
                        'mimeTypes' => [
                            'video/mp4',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid MP4 video',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your default options here
        ]);
    }
}
