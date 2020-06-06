<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Comment;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('author')
            ->add('content')
            ->add('image', EntityType::class, [
                'class' => Image::class,
                'label' => null,
                'attr' => [
                    'required' => false,
                    'class' => 'd-none'
                ]
                ])
            ->add('album', EntityType::class, [
                'class' => Album::class,
                'label' => null,
                'attr' => [
                    'required' => false,
                    'class' => 'd-none'
                ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
