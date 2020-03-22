<?php

namespace App\DataFixtures;

use App\Entity\Ship;
use App\Entity\System;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ShipFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $users = $manager->getRepository(User::class)->findAll();
        $systems = $manager->getRepository(System::class)->findAll();

        $factory = \Faker\Factory::create();

        /** @var User $user */
        foreach ($users as $user) {
            $ship = new Ship();
            $ship->setUser($user)
                ->setSystem($factory->randomElement($systems))
                ->setX(1)
                ->setY(1);
            $manager->persist($ship);
        }
        $manager->flush();

    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array class-string[]
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            SystemFixtures::class
        ];
    }
}
