<?php


namespace App\DataFixtures\Economy;

use App\DataFixtures\DockableFixtures;
use App\Entity\Component\Market;
use App\Entity\Dockable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Forge a link between Markets and dockables
 * as a fixture for modularity
 */
class MarketDockableFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            DockableFixtures::class,
            MarketFixtures::class
        ];
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        /** @var Market[] $markets */
        $markets = $manager->getRepository(Market::class)->findAll();
        $dockables = $manager->getRepository(Dockable::class)->findAll();

        $faker = Factory::create();

        foreach ($markets as $market) {
            $dockable = $faker->randomElement($dockables);

            if (!$dockable) {
                break;
            }

            if (($key = array_search($dockable, $dockables)) !== false) {
                unset($dockables[$key]);
            }

            $market->setDockable($dockable);
        }

        $manager->flush();
    }


}
