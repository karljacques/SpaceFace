<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Component\Storage;
use App\Entity\Ship;
use App\Entity\System;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ShipFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $characters = $manager->getRepository(Character::class)->findAll();
        $systems = $manager->getRepository(System::class)->findAll();

        $factory = Factory::create();

        /** @var Character $character */
        foreach ($characters as $character) {
            $ship = new Ship();
            $ship->setOwner($character)
                ->setSystem($factory->randomElement($systems))
                ->setX(1)
                ->setY(1)
                ->setMaxFuel($factory->numberBetween(100, 200))
                ->setFuel($ship->getMaxFuel())
                ->setMaxPower(1000);

            $storage = new Storage();
            $storage->setCapacity(100);
            $ship->setStorageComponent($storage);

            $manager->persist($storage);
            $manager->persist($ship);
        }
        $manager->flush();

    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array<class-string>
     */
    public function getDependencies()
    {
        return [
            CharacterFixtures::class,
            SystemFixtures::class
        ];
    }
}
