<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Email*']
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe ne correspondent pas.',
                'required' => true,
                'first_options'  => ['attr' => ['placeholder' => 'Mot de passe*', 
                        'class' => 'col-12 col-md-6'], 
                        'label' => false],
                'second_options' => ['attr' => ['placeholder' => 'Confirmation*',
                        'class' => 'col-12 col-md-6'], 
                        'label' => false],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit être d\'au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]
            ])
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
            ->add('phone', TelType::class,
            [
                'required' => false,
                'attr' => ['placeholder' => 'Téléphone']
            ])
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
