<?php


namespace App\Service\Factories\Command;


use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Entity\Ship;
use App\Exception\ValidationError;
use App\Exception\ValidationException;
use App\Service\Calculators\MovementCostCalculatorInterface;
use App\Util\HexVector;
use App\Util\Location;
use Symfony\Component\HttpFoundation\Request;

class MovementCommandFactory implements CommandFactoryInterface
{
    protected MovementCostCalculatorInterface $movementCostCalculator;

    public function __construct(MovementCostCalculatorInterface $movementCostCalculator)
    {
        $this->movementCostCalculator = $movementCostCalculator;
    }

    /**
     * @param Request $request
     * @param Ship $ship
     * @return CommandInterface
     * @throws ValidationException
     */
    public function createCommand(Request $request, Ship $ship): CommandInterface
    {
        $direction = $request->get('direction');
        $translation = new HexVector($direction['x'], $direction['y']);

        if (!$this->isValid($translation)) {
            throw new ValidationException([
                new ValidationError('The direction supplied is not valid', 'direction')
            ]);
        }

        $targetPosition = $ship->getLocation()->getVector()->add($translation);
        $targetLocation = new Location($ship->getSystem(), $targetPosition);

        $fuelCost = $this->movementCostCalculator->calculateFuelCost($ship->getLocation(), $targetLocation);

        return new MovementCommand($ship, $translation, $fuelCost);
    }

    protected function isValid(HexVector $translation)
    {
        return abs($translation->getQ() + $translation->getR()) === 1;
    }

    public function getSchema(): string
    {
        return 'move.json';
    }
}
