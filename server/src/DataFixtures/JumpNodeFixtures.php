<?php


namespace App\DataFixtures;


use App\Entity\JumpNode;
use App\Entity\System;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JumpNodeFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return string[]
     */
    public function getDependencies()
    {
        return [SystemFixtures::class];
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var System[] $systems */
        $systems = $manager->getRepository(System::class)->findAll();

        $faker = \Faker\Factory::create();

        foreach ($systems as $a) {
            foreach ($systems as $b) {
                $entryX = $faker->numberBetween(1, $a->getSizeX());
                $entryY = $faker->numberBetween(1, $a->getSizeY());

                $exitX = $faker->numberBetween(1, $b->getSizeX());
                $exitY = $faker->numberBetween(1, $b->getSizeY());

                $jumpNode = new JumpNode();

                $jumpNode->setEntrySystem($a)
                    ->setEntryX($entryX)
                    ->setEntryY($entryY)
                    ->setExitSystem($b)
                    ->setExitX($exitX)
                    ->setExitY($exitY);

                $manager->persist($jumpNode);

                $reverseJumpNode = new JumpNode();
                $reverseJumpNode->setEntrySystem($b)
                    ->setEntryX($exitX)
                    ->setEntryY($exitY)
                    ->setExitSystem($a)
                    ->setExitX($entryX)
                    ->setExitY($entryY);

                $manager->persist($reverseJumpNode);
            }
        }

        $manager->flush();
    }
}
