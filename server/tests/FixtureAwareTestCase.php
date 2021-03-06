<?php

namespace App\Tests;

use App\Kernel;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;

/**
 * Class FixtureAwareTestCase
 * @package App\Tests
 */
trait FixtureAwareTestCase
{
    /**
     * @var ORMExecutor
     */
    private ?ORMExecutor $fixtureExecutor = null;
    /**
     * @var ContainerAwareLoader
     */
    private ?ContainerAwareLoader $fixtureLoader = null;

    protected function getEntityManager(): EntityManagerInterface
    {
        /** @var EntityManagerInterface $entityManager */

        /** @var Kernel $kernel */
        $kernel = self::$kernel;

        $entityManager = $kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        return $entityManager;
    }

    protected function getRepository(string $class): ObjectRepository
    {
        return $this->getEntityManager()->getRepository($class);
    }

    /**
     * Adds a new fixture to be loaded.
     * @param FixtureInterface $fixture
     */
    protected function addFixture(FixtureInterface $fixture): void
    {
        $this->getFixtureLoader()->addFixture($fixture);
    }

    /**
     * Executes all the fixtures that have been loaded so far.
     */
    protected function executeFixtures(): void
    {
        $this->getFixtureExecutor()->execute($this->getFixtureLoader()->getFixtures());
    }

    /**
     * Get the class responsible for loading the data fixtures.
     * And this will also load in the ORM Purger which purges the database before loading in the data fixtures
     */
    private function getFixtureExecutor(): ORMExecutor
    {
        if (!$this->fixtureExecutor) {
            /** @var EntityManager $entityManager */
            $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
            $this->fixtureExecutor = new ORMExecutor($entityManager, new ORMPurger($entityManager));
        }
        return $this->fixtureExecutor;
    }

    /**
     * Get the Doctrine data fixtures loader
     */
    private function getFixtureLoader(): ContainerAwareLoader
    {
        if (!$this->fixtureLoader) {
            $this->fixtureLoader = new ContainerAwareLoader(static::$kernel->getContainer());
        }
        return $this->fixtureLoader;
    }

    protected function addFixtureByName(string $name)
    {
        $fixture = static::$kernel->getContainer()->get("test.$name");
        $this->addFixture($fixture);
    }
}
