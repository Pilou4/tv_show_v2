<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'email',
            EmailType::class,
            [
                "label" => "Adresse email",
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-input'],
            ]
        );

        /*
        // Champs mot de passe sans demander la confirmation avec un deuxieme champs
        $builder->add(
            'password',
            PasswordType::class,
            [
                "label" => "Mot de passe"
            ]
        );
        */

        $builder->add(
            'password', 
            RepeatedType::class, 
            [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mot de passe ne sont pas identiques',
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'label_attr' => ['class' => 'form-label']
                ],
                'second_options' => [
                    'label' => 'Repeter le mot de passe',
                    'label_attr' => ['class' => 'form-label']
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}