<?php


namespace App\Controller;


use App\Command\CommandInterface;
use App\Entity\User;
use App\Service\Factories\Command\CommandFactoryInterface;
use App\Service\Factories\Command\DockCommandFactory;
use App\Service\Factories\Command\Economy\Market\PurchaseCommandFactory;
use App\Service\Factories\Command\JumpCommandFactory;
use App\Service\Factories\Command\MovementCommandFactory;
use App\Service\Factories\Command\UndockCommandFactory;
use LogicException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AbstractCommandController extends AbstractGameController
{
    public function createCommand(string $commandType): CommandInterface
    {
        /** @var CommandInterface $commandType */
        $factoryName = $commandType::getFactoryName();

        /** @var CommandFactoryInterface $factory */
        $factory = $this->get($factoryName);

        /** @var TokenStorageInterface $tokenStorageInterface */
        $tokenStorageInterface = $this->get('security.token_storage');

        /** @var User $user */
        $user = $tokenStorageInterface->getToken()->getUser();
        $ship = $user->getCharacters()->first()->getShips()->first();

        /** @var RequestStack $requestStack */
        $requestStack = $this->get('request_stack');
        $request = $requestStack->getCurrentRequest();

        // Check schema match
        if ($request->get('_schema') !== $factory->getSchema()) {
            throw new LogicException('Factory schema does not match request schema');
        }

        return $factory->createCommand($request, $ship);
    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), self::getCommandFactories());
    }

    private static function getCommandFactories(): array
    {
        return [
            MovementCommandFactory::class,
            JumpCommandFactory::class,
            DockCommandFactory::class,
            UndockCommandFactory::class,
            PurchaseCommandFactory::class
        ];
    }
}
