<?php


namespace App\Service\Factories\Command;


use App\Command\CommandInterface;
use App\Command\JumpCommand;
use App\Entity\Ship;
use App\Exception\ValidationError;
use App\Exception\ValidationException;
use App\Repository\JumpNodeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class JumpCommandFactory extends AbstractCommandParamConverter
{
    protected JumpNodeRepository $jumpNodeRepository;

    public function __construct(JumpNodeRepository $jumpNodeRepository)
    {
        $this->jumpNodeRepository = $jumpNodeRepository;
    }

    /**
     * @param Request $request
     * @param Ship $ship
     * @return CommandInterface
     * @throws ValidationException
     */
    public function createCommand(Request $request, Ship $ship): CommandInterface
    {
        $nodeId = $request->get('node');

        $node = $this->jumpNodeRepository->find($nodeId);

        if (null === $node) {
            throw new ValidationException([
                new ValidationError('The node supplied is not valid', 'node')
            ]);
        }

        return new JumpCommand($ship, $node);
    }

    public function getSchemaFilename(): string
    {
        return 'jump.json';
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === JumpCommand::class;
    }
}
