<?php


namespace App\Command;


use App\Entity\JumpNode;
use App\Entity\Ship;
use App\Service\Factories\Command\JumpCommandFactory;

class JumpCommand extends AbstractShipCommand
{
    protected JumpNode $node;

    public function __construct(Ship $ship, JumpNode $node)
    {
        parent::__construct($ship);

        $this->node = $node;
    }

    /**
     * @return JumpNode
     */
    public function getNode(): JumpNode
    {
        return $this->node;
    }



    public static function getFactoryName(): string
    {
        return JumpCommandFactory::class;
    }
}
