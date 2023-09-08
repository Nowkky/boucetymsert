<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceLabel;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('society', TextType::class,
        [
            'required' => false,
            'attr' => ['placeholder' => 'Entreprise/Association', 'style' => 'bottom:0']
        ])
        ->add('civility', ChoiceType::class,
        [
            'label' => 'Civilité*',
            'choices' => ['M.' => 'M.', 'Mme.' => 'Mme.'],
            'expanded' => true,
            'multiple' => false,
            'required' => true,
        ])
        ->add('lastname', TextType::class,
        [
            'required' => true,
            'attr' => ['placeholder' => 'Votre nom*']
            
        ])
        ->add('firstname', TextType::class,
        [
            'required' => false,
            'attr' => ['placeholder' => 'Votre prénom']
        ])
        ->add('email', EmailType::class,
        [
            'required' => true,
            'attr' => ['placeholder' => 'Adresse mail*']
        ])
        ->add('phone', TelType::class,
        [
            'required' => false,
            'attr' => ['placeholder' => 'Téléphone']
        ])
        // ->add('address', TextType::class,
        // [
        //     'required' => false,
        //     'attr' => ['placeholder' => 'Votre société']
        // ])
        ->add('city', TextType::class,
        [
            'required' => false,
            'attr' => ['placeholder' => 'Ville de la demande*']
        ])
        ->add('postal', TextType::class,
        [
            'required' => false,
            'attr' => ['placeholder' => 'Code postal']
        ])
        ->add('message', TextareaType::class, [
            'attr' => ['style' => 'width:100%;height:10em;','placeholder' => 'Votre message*'],
            'required' => true,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
