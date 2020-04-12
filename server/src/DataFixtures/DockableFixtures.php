<?php


namespace App\DataFixtures;


use App\DataFixtures\Helper\SystemHelper;
use App\Entity\Dockable;
use App\Entity\System;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DockableFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $systems = $manager->getRepository(System::class)->findAll();

        $dockableCount = 20;

        $faker = Factory::create();

        for ($i = 0; $i < $dockableCount; $i++) {
            $dockable = new Dockable();
            $system = $faker->randomElement($systems);

            $dockable->setLocation(SystemHelper::randomLocation($system));
            $manager->persist($dockable);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [SystemFixtures::class];
    }
}
