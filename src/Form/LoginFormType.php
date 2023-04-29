<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', EmailType::class, [
                'label' => 'email',
                'attr' => [
                    'id' => 'username',
                ]
            ])            
            ->add('password', PasswordType::class, [
                'label' => 'password',
                'attr' => [
                    'id' => 'password',
                    'name' => '_password'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'required' => false,
            'mapped' => false,
            'translation_domain' => 'label',
        ]);
    }
}
