<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'object',
            TextType::class, 
            [
                'label' => 'object',
                'label_attr' => ['class' => 'form-label'],
                'attr' => [
                    'class' => 'form-contact-object'
                ]
            ]
        );
        $builder->add(
            'email',
            EmailType::class,
            [
                'label' => 'votre e-mail',
                'label_attr' => ['class' => 'form-label'],
                'attr' => [
                    'class' => 'form-contact-email'
                ]
            ]
        );
        $builder->add(
            'message',
            CKEditorType::class, 
            [
                'label' => 'Votre message',
                'label_attr' => ['class' => 'form-label'],
                'attr' => [
                    'class' => 'form-contact-message'
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
