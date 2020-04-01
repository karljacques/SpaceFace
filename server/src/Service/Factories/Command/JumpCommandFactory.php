<?php


namespace App\Service\Factories\Command;


use App\Command\CommandInterface;
use App\Command\JumpCommand;
use App\Entity\Ship;
use App\Repository\JumpNodeRepository;
use Symfony\Component\HttpFoundation\Request;

class JumpCommandFactory implements CommandFactoryInterface
{
    protected $jumpNodeRepository;

    public function __construct(JumpNodeRepository $jumpNodeRepository)
    {
        $this->jumpNodeRepository = $jumpNodeRepository;
    }

    public function createCommand(Request $request, Ship $ship): CommandInterface
    {
        $nodeId = $request->get('node');

        $node = $this->jumpNodeRepository->find($nodeId);

        return new JumpCommand($ship, $node);
    }

    public function getSchema(): string
    {
        return 'jump.json';
    }
}
