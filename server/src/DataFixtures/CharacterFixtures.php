<?php


namespace App\DataFixtures;


use App\Entity\Character;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CharacterFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [UserFixtures::class];
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        /** @var User[] $users */
        $users = $manager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            $character = new Character();

            $character->setUser($user);
            $manager->persist($character);
        }

        $manager->flush();
    }
}
