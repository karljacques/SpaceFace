<?php


namespace App\DataFixtures\Economy;


use App\Entity\Commodity;
use App\Entity\Component\Market;
use App\Entity\Join\MarketCommodity;
use App\Entity\Join\StoredCommodity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MarketCommodityFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            MarketFixtures::class,
            CommodityFixtures::class
        ];
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        // Load all markets
        /** @var Market[] $markets */
        $markets = $manager->getRepository(Market::class)->findAll();

        $faker = Factory::create();

        foreach ($markets as $market) {
            $marketType = $faker->randomElement($this->getMarketTypes());

            foreach ($marketType['sell'] as $soldCommodity) {
                /** @var Commodity $commodity */
                $commodity = $manager->getRepository(Commodity::class)
                    ->findOneBy(['name' => $soldCommodity]);

                $marketCommodity = new MarketCommodity();
                $marketCommodity->setCommodity($commodity)
                    ->setMarket($market)
                    ->setSell(1);

                $manager->persist($marketCommodity);

                // Get Market storage
                $storage = $market->getStorage();

                $storedCommodity = new StoredCommodity();
                $storedCommodity->setCommodity($commodity)
                    ->setStorageComponent($storage)
                    ->setQuantity(100);

                $storage->addStoredCommodity($storedCommodity);

                $manager->persist($storedCommodity);
            }

            foreach ($marketType['buy'] as $soldCommodity) {
                /** @var Commodity $commodity */
                $commodity = $manager->getRepository(Commodity::class)
                    ->findOneBy(['name' => $soldCommodity]);

                $marketCommodity = new MarketCommodity();
                $marketCommodity->setCommodity($commodity)
                    ->setMarket($market)
                    ->setBuy(1);

                $manager->persist($marketCommodity);

                $storage = $market->getStorage();

                $storedCommodity = new StoredCommodity();
                $storedCommodity->setCommodity($commodity)
                    ->setStorageComponent($storage)
                    ->setQuantity(100);

                $storage->addStoredCommodity($storedCommodity);

                $manager->persist($storedCommodity);
            }

        }

        $manager->flush();
    }

    protected function getMarketTypes(): array
    {
        return [
            'Farm' => [
                'sell' => [
                    'Food'
                ],
                'buy' => [
                    'Machinery',
                    'Medicine',
                    'Chemicals'
                ]
            ],
            'Chemical Plant' => [
                'sell' => [
                    'Chemicals',
                    'Weapons'
                ],
                'buy' => [
                    'Food',
                    'Machinery'
                ]
            ],
            'Factory' => [
                'sell' => [
                    'Machinery',
                    'Weapons'
                ],
                'buy' => [
                    'Chemicals',
                    'Food'
                ]
            ],
            'Military Base' => [
                'sell' => [

                ],
                'buy' => [
                    'Weapons',
                    'Food',
                    'Medicine'
                ]
            ]
        ];
    }
}
