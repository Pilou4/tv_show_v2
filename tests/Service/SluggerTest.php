<?php

namespace App\Tests\Service;

use App\Service\Slugger;
use PHPUnit\Framework\TestCase;

// je crée une classe de test pour chaque classe testée
// test unitaire => TestCase
class SluggerTest extends TestCase
{
    // je peux créer plusieur test en créant des methode dans ma classe de test
    // le nom des methodes de test doivent commencer par test...
    public function testSluggify()
    {
        // je fait ce qui doit être testé
        $slugger = new Slugger();
        $slug = $slugger->sluggify(" C'est Top ! ");
        $slug2 = $slugger->sluggify(" Sex And The City !");
        $slug3 = $slugger->sluggify(" THE WALKING DEAD ! ");
        $slug4 = $slugger->sluggify(" a VERY secret Service ! ");
        $slug5 = $slugger->sluggify(" Fastest CAR ! ");

        // puis j'utilise le framework de test pour verifier que j'ai bien le resultat attendu
        // dans le cas présent la chaine à sluggifier est " C'est Top ! " mon slug doit correspondre à "c'est_top_!"
        $this->assertEquals("c'est-top-!", $slug);
        $this->assertEquals("sex-and-the-city-!", $slug2);
        $this->assertEquals("the-walking-dead-!", $slug3);
        $this->assertEquals("a-very-secret-service-!", $slug4);
        $this->assertEquals("fastest-car-!", $slug5);
    }
}