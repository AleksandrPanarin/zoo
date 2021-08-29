<?php

namespace App\DataFixtures;

use App\Entity\Animals\Crocodile;
use App\Entity\Animals\Elephant;
use App\Entity\Animals\Lion;
use App\Entity\Cage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $cage1 = new Cage();
        $cage1->setNumber(1);
        $manager->persist($cage1);

        for ($i = 1; $i <= 5; $i++) {
            $lion = new Lion();
            $manager->persist($lion);
            $cage1->addAnimal($lion);
        }
        $cage2 = new Cage();
        $cage2->setNumber(2);
        $manager->persist($cage2);

        for ($i = 1; $i <= 5; $i++) {
            $crocodile = new Crocodile();
            $manager->persist($crocodile);
            $cage2->addAnimal($crocodile);
        }
        $cage3 = new Cage();
        $cage3->setNumber(3);
        $manager->persist($cage3);

        for ($i = 1; $i <= 5; $i++) {
            $elephant = new Elephant();
            $manager->persist($crocodile);
            $cage3->addAnimal($elephant);
        }
        $manager->flush();
    }
}
