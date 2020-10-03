<?php


namespace App\Service\Factories\Command;


use App\Command\CommandInterface;
use App\Command\DockCommand;
use App\Entity\Ship;
use App\Exception\ValidationError;
use App\Exception\ValidationException;
use App\Repository\DockableRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class DockCommandFactory extends AbstractCommandParamConverter
{
    protected DockableRepository $dockableRepository;

    public function __construct(DockableRepository $dockableRepository)
    {
        $this->dockableRepository = $dockableRepository;
    }

    /**
     * @param Request $request
     * @param Ship $ship
     * @return CommandInterface
     * @throws ValidationException
     */
    public function createCommand(Request $request, Ship $ship): CommandInterface
    {
        $dockable = $this->dockableRepository->find($request->get('dockable'));

        if (null === $dockable) {
            throw new ValidationException([
                new ValidationError('The dockable supplied is not valid', 'dockable')
            ]);
        }

        return new DockCommand($ship, $dockable);
    }

    protected function getSchemaFilename(): string
    {
        return 'dock.json';
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === DockCommand::class;
    }
}
