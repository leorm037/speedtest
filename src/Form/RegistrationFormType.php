<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('name', null, [
                    'label' => 'name',
                    'attr' => [
                        'autocomplete' => 'name',
                    ],
                    'help' => 'name.complete',                    
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter your name',
                                ]),
                    ],
                ])
                ->add('email', RepeatedType::class, [
                    'type' => EmailType::class,
                    'options' => [
                        'attr' => [
                            'autocomplete' => 'email',
                        ],
                        'row_attr' => [
                            'class' => 'col-sm-12 col-xl-6',
                        ],
                    ],
                    'first_options' => [
                        'label' => 'email',
                    ],
                    'second_options' => [
                        'label' => 'email.confirm',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a password',
                                ]),
                    ],
                ])
                ->add('plainPassword', RepeatedType::class, [
                    'mapped' => false,
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'password',
                    ],
                    'second_options' => [
                        'label' => 'password.confirm',
                    ],
                    'options' => [
                        'attr' => ['autocomplete' => 'new-password'],
                        'row_attr' => [
                            'class' => 'col-sm-12 col-xl-6',
                        ],
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a password',
                                ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                                ]),
                    ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'required' => false,
            'translation_domain' => 'label',
        ]);
    }

}
