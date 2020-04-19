<?php


namespace App\DataFixtures\Economy;


use App\Entity\Component\Market;
use App\Entity\Component\Storage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MarketFixtures extends Fixture
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $numberOfMarkets = $faker->numberBetween(1, 10);

        for ($i = 0; $i < $numberOfMarkets; $i++) {
            $market = new Market();

            $storage = new Storage();
            $storage->setCapacity(100000);

            $market->setStorage($storage);

            $manager->persist($market);
        }

        $manager->flush();
    }
}
