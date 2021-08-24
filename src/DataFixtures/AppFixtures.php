<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Faker\Factory;
use App\Entity\TvShow;
use App\Entity\Character;
use App\Entity\Person;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        // je crée 10 catégories
        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setLabel($faker->name);
            $manager->persist($category);
        }

        // je créé 20 personnes
        for ($i = 0; $i < 20; $i++) {
            $person = new Person();
            $person->setFirstName($faker->firstName);
            $person->setLastName($faker->lastName);
            $person->setGender($faker->title);
            $manager->persist($person);
        }

        // je crée 100 series
        for($i = 0; $i < 100; $i++) {
            $tvShow = new TvShow();
            $tvShow->setTitle($faker->catchPhrase());
            $tvShow->setSynopsis($faker->catchPhrase());
            $tvShow->addCategory($category);
            $manager->persist($tvShow);

            // pour chaque serie je créer aleatoirement entre 1 et 10 personnage
            for($j = 0; $j < mt_rand(1,10); $j++)
            {
                $character = new Character();
                $character->setName($faker->name);
                $character->setTvShow($tvShow);
                $manager->persist($character);
            }

        }


        $manager->flush();
    }
}
