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
            $system->setName($faker->domainName);

            $manager->persist($system);
        }

        $manager->flush();
    }
}
