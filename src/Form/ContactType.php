<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
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
            'label' => 'Société',
            'required' => false,
        ])
        ->add('civility', ChoiceType::class,
        [
            'label' => 'Civilité*',
            'choices' => ['M.' => 'M.', 'Mme.' => 'Mme.'],
            'expanded' => true,
            'multiple' => false,
            'required' => true
        ])
        ->add('lastname', TextType::class,
        [
            'label' => 'Nom*',
            'required' => true
        ])
        ->add('firstname', TextType::class,
        [
            'label' => 'Prénom',
            'required' => true
        ])
        ->add('email', EmailType::class,
        [
            'label' => 'Votre adresse mail*',
            'required' => true
        ])
        ->add('phone', TelType::class,
        [
            'label' => 'Téléphone',
            'required' => false,
        ])
        ->add('address', TextType::class,
        [
            'label' => 'Adresse',
            'required' => false,
        ])
        ->add('city', TextType::class,
        [
            'label' => 'Ville',
            'required' => false,
        ])
        ->add('postal', TextType::class,
        [
            'label' => 'Code postal',
            'required' => false,
        ])
        ->add('message', TextareaType::class, [
            'label' => 'Votre message',
            'attr' => ['rows' => 6],
            'required' => true
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
