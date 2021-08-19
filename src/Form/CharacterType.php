<?php

namespace App\Form;

use App\Entity\Person;
use App\Entity\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            "name",
            TextType::class,
            [
                "label" => "Nom du personnage",
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-input'],
                'help' => '* champs obligatoire',

            ]
        );

        $builder->add(
            "actors",
            EntityType::class,
            [
                "class" => Person::class,
                "choice_label" => function (Person $person) {
                    return $person->getFullName();
                },
                // 'label_attr' => ['class' => 'form-label'],
                "required" => false,
                "multiple" => true,
                "expanded" => true,

            ]
        );

        $builder->add(
            "picture",
            FileType::class,
            [
                "label" => "Image",
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-input'],
                "mapped" => false,
                "required" => false,
                "constraints" => [
                    new Image([
                        'maxSize' => '1024k'
                    ])
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}