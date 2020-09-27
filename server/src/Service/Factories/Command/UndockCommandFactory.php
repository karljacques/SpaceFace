<?php


namespace App\Service\Factories\Command;


use App\Command\CommandInterface;
use App\Command\UndockCommand;
use App\Entity\Ship;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class UndockCommandFactory extends AbstractCommandParamConverter
{

    public function createCommand(Request $request, Ship $ship): CommandInterface
    {
        return new UndockCommand($ship);
    }

    protected function getSchemaFilename(): ?string
    {
        return null;
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === UndockCommand::class;
    }
}
