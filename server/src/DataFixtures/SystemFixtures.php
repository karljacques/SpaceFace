<?php

namespace App\DataFixtures;

use App\Entity\System;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SystemFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $systemCount = 5;
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < $systemCount; $i++) {
            $system = new System();
            $system->setName(ucwords($faker->domainWord));

            $system->setSizeX($faker->numberBetween(10, 15));
            $system->setSizeY($faker->numberBetween(10, 20));

            $manager->persist($system);
        }

        $manager->flush();
    }
}
