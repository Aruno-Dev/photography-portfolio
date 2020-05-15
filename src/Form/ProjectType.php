<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label'=> 'titre du projet',
                'attr'=> [
                    'placeholder'=> 'Mon titre'
                    ]
            ])
            ->add('introduction', TextType::class, [
                'label'=> 'introduction du projet',
                'attr'=> [
                    'placeholder'=> 'Mon introduction'
                    ]
            ])
            ->add('description', TextareaType::class, [
                'label'=> 'description du projet',
                'attr'=> [
                    'placeholder'=> 'Ma description'
                    ]
            ])
            ->add('image', UrlType::class, [
                'label'=> 'image du projet',
                'attr'=> [
                    'placeholder'=> 'Mon image'
                    ]
            ])
            ->add('github', UrlType::class, [
                'label'=> 'lien github du projet',
                'attr'=> [
                    'placeholder'=> 'Mon lien github'
                    ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'enregistrer',
                'attr' => [
                    'class' =>'btn btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
