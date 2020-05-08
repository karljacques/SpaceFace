<?php


namespace App\DataFixtures;


use App\DataFixtures\Helper\SystemHelper;
use App\Entity\JumpNode;
use App\Entity\System;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JumpNodeFixtures extends Fixture implements DependentFixtureInterface
{


    /**
     * @return array<class-string>
     */
    public function getDependencies(): array
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

        foreach ($systems as $a) {
            foreach ($systems as $b) {
                if ($a === $b) {
                    continue;
                }

                $jumpNode = new JumpNode();

                $jumpNode->setLocation(SystemHelper::randomLocation($a));
                $jumpNode->setExitLocation(SystemHelper::randomLocation($b));

                $manager->persist($jumpNode);

                $reverseJumpNode = new JumpNode();
                $reverseJumpNode->setLocation($jumpNode->getExitLocation())
                    ->setExitLocation($jumpNode->getLocation());

                $manager->persist($reverseJumpNode);
            }
        }

        $manager->flush();
    }
}
