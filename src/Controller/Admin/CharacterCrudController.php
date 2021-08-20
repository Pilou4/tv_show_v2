<?php

namespace App\Controller\Admin;

use App\Entity\Character;
use App\Form\CharacterType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CharacterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Character::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return 
        [
            TextField::new('name'),
            ImageField::new('pictureFilename')
                ->setUploadDir('public/uploads/pictures_characters')
                ->setBasePath('/uploads/pictures_characters'),
                // ->setBasePath('/uploads'),
            AssociationField::new('actors','acteur'),
            AssociationField::new('tvShow','tv_show')
            // CollectionField::new('actors', 'acteur')
            //     ->setEntryType(CharacterType::class),
        ];
    }
}
