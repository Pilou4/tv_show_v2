<?php

namespace App\Controller\Admin;

use App\Entity\Season;
use App\Entity\TvShow;
use App\Entity\Category;
use App\Form\SeasonType;
use App\Form\CharacterType;
use Symfony\Component\Form\Button;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TvShowCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TvShow::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'titre'),
            TextField::new('slug'),
            TextareaField::new('synopsis'),
            ImageField::new('pictureFile')
                ->setUploadDir('public/uploads/img-tv_show')
                ->setBasePath('/uploads/img-tv_show'),
            DateField::new('releaseDate'),
            AssociationField::new('directedBy'),
            AssociationField::new('categories', 'Categorie'),
            CollectionField::new('seasons', 'saisons')
                ->allowAdd()
                ->setEntryType(SeasonType::class),
            DateField::new('createdAt')->onlyOnIndex(),
            DateField::new('updatedAt')->onlyOnIndex(),
            NumberField::new('rating'),
            CollectionField::new('characters', 'acteurs')
                ->allowAdd()
                ->setEntryType(CharacterType::class),
        ];
    }
}
