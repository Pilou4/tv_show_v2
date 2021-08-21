<?php

namespace App\Controller\Admin;

use App\Entity\Season;
use App\Form\EpisodeType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SeasonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Season::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            NumberField::new('number'),
            NumberField::new('year'),
            AssociationField::new('tvShow'),
            CollectionField::new('episodes')
                ->allowAdd()
                ->setEntryType(EpisodeType::class),
        ];
    }
}
