<?php

namespace App\Controller\Admin;

use App\Entity\Person;
use App\Form\CharacterType;
use Symfony\Component\VarDumper\Cloner\Data;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class PersonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Person::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstName', 'Prénom'),
            TextField::new('lastName', 'Nom'),
            DateField::new('birthDate', 'Date de naissance'),
            ChoiceField::new('gender', 'Genre')->setChoices([ 'homme' =>'homme', 'femme' =>'femme']),
            AssociationField::new('characters', 'personnages')
        ];
    }
}
