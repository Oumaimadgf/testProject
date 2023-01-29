<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class, array('attr' => array('class' => 'form-control','required'=> false )))
            ->add('image', FileType::class, [
                'label'=> 'image',
                'data_class' => null,
                'required'   => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/*'
                        ],
                        'mimeTypesMessage' => 'Le fichier n\'est pas valide, assurez vous d\'avoir un fichier au format PNG, JPG, JPEG)',
                    ]),
                ]
            ])
            ->add('url', FileType::class, [
                'label'=> 'filename',
                'required'   => false,
                'data_class' => null,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Le fichier n\'est pas valide, assurez vous d\'avoir un fichier au format PDF)',
                    ]),
                ]
            ])

            ->add('description',TextType::class, array('attr' => array('class' => 'form-control','required'=> false )))
            ->add('number',NumberType::class, array('attr' => array('class' => 'form-control','required'=> false )))
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    '' => '',
                    'done' => 'done',
                    'blocked' => 'blocked',
                    'in progress' =>  'progress'
                ],
                'attr' => array('class' => 'form-control'),
                'label' => 'status', 'required'=> true


            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,

        ]);
    }
}
