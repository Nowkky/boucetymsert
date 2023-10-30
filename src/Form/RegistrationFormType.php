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
use Symfony\Component\Validator\Constraints\Regex;

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
                    new Regex([
                        'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*.-]).{8,}$/', 
                        'message' => 'Votre mot de passe doit faire au minimum 8 caractères et doit être composé 
                        d\'une majuscule, d\'une minuscule, d\'un chiffre et d\'un caractère spécial.'
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
            ->add('phone', TextType::class,
            [
                'required' => false,
                'attr' => ['placeholder' => 'Téléphone'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/', 
                        'message' => 'Votre numéro de téléphone n\'est pas valide (chiffres de 0-9 et 10 caractères min.)'
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => '10 caractères minimum',
                        'max' => 20,
                        'maxMessage' => '20 caractères maximum'
                ])]
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
