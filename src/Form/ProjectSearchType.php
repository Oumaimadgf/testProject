<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\ProjectSearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class ProjectSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('title', EntityType::class, [
                'class' => Project::class,
                'empty_data'  => null,
                'choice_label' => 'title',
                'label' => false,
                'required'=> false,
                'placeholder'=>'project name'
            ])
          ->add('status', ChoiceType::class, [
              'empty_data'  => null,
              'choices'  => [
                  'done' => 'done',
                  'blocked' => 'blocked',
                  'in progress' =>  'progress'
              ],
              'attr' => array('class' => 'form-control'),
             'label' => false, 'required'=> false,
              'placeholder'=>'status project'

          ])
          ->add('filename',TextType::class, array('attr' =>  array('class' => 'form-control', 'placeholder'=>'filename or url' ),'required'=> false,
              'label'=> false
             ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectSearch::class,
            'required' => false
        ]);
    }
}
