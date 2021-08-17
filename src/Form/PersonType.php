<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'firstName',
            TextType::class,
            [
                'label' => 'Prénom'
            ]  
        );
        $builder->add(
            'lastName',
            TextType::class,
            [
                'label' => 'Nom'
            ]

        );
        $builder->add(
            'birthDate',
            BirthdayType::class,
            [
                'label' => 'Date de naissance',
                'placeholder' => [  
                    'day' => 'jour',
                    'month' => 'mois',
                    'year' => 'année',
                ],
                'format' => 'dd MM yyyy',
                'required' => false
            ]
        );
        $builder->add(
            'gender',
            ChoiceType::class,
            [
                'choices' => [
                    'homme' => 1,
                    'femme' => 2
                ],
                'label' => 'Genre'
            ]
        );
        
        // $builder->add(
        //     "synopsis",
        //     TextareaType::class,
        //     [
        //         "label" => "Synopsis",
        //         "required" => false,
        //         "attr" => [
        //             "rows" => 5
        //         ]
        //     ]
        // );
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
