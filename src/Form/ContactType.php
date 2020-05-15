<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Email', EmailType::class, [
                'label' => 'Your Email',
                'attr' => [
                    'autofocus' => true,
                    'required' => true
                ]
            ])
            ->add('Subject', TextType::class, [
                'label' => 'Subject',
                'attr' => [
                    'required' => true
                ]
            ])
            ->add('Message', TextareaType::class, [
                'label' => 'Your Message',
                'attr' => [
                    'required' => true
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
