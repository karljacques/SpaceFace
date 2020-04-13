<?php


namespace App\DataFixtures\Economy;


use App\Entity\Commodity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommodityFixtures extends Fixture
{
    const COMMODITIES = [
        'Food' => [
            'value' => 1,
            'ethics' => 1,
            'size' => 1,
            'weight' => 200
        ],
        'Machinery' => [
            'value' => 2,
            'size' => 6,
            'weight' => 5000
        ],
        'Medicine' => [
            'value' => 3,
            'ethics' => 1,
            'size' => 3,
            'weight' => 20
        ],
        'Weapons' => [
            'value' => 4,
            'ethics' => -2,
            'size' => 4,
            'weight' => 1200
        ],
        'Chemicals' => [
            'value' => 2,
            'size' => 2,
            'weight' => 200
        ]
    ];

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::COMMODITIES as $name => $details) {
            $commodity = new Commodity();
            $commodity->setName($name)
                ->setSize($details['size'])
                ->setWeight($details['weight']);

            $manager->persist($commodity);
        }

        $manager->flush();
    }
}
