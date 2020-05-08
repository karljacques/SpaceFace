<?php


namespace App\DataFixtures;


use App\Entity\Sector;
use App\Entity\System;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class SectorFixtures extends Fixture implements DependentFixtureInterface
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     *  Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $systems = $manager->getRepository(System::class)->findAll();

        /** @var System $system */
        foreach ($systems as $system) {
            for ($x = 1; $x <= $system->getSizeX(); $x++) {
                for ($y = 1; $y <= $system->getSizeX(); $y++) {
                    $this->createSector($manager, $system, $x, $y);
                }
            }
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param System $system
     * @param int $x
     * @param int $y
     *
     * @return void
     */
    private function createSector(ObjectManager $manager, System $system, int $x, int $y)
    {
        $type = $this->faker->numberBetween(0, 3);

        if ($type === 0) {
            return;
        }

        $sector = new Sector();
        $sector->setType($type)
            ->setSystem($system)
            ->setX($x)
            ->setY($y);

        $manager->persist($sector);
    }

    public function getDependencies()
    {
        return [SystemFixtures::class];
    }
}
