<?php


namespace App\Command;


use App\Entity\JumpNode;
use App\Entity\Ship;
use App\Service\Validation\Rules\Docking\MustNotBeDockedRule;
use App\Service\Validation\Rules\Generic\MustHaveSameLocationRule;
use App\Service\Validation\Rules\Ship\MustHavePowerRule;
use App\Service\Validation\Rules\Ship\MustNotBeInCooldownRule;

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


    public function getValidationRules(): array
    {
        $ship = $this->getShip();
        $node = $this->getNode();

        return [
            new MustNotBeDockedRule($ship),
            new MustHaveSameLocationRule($ship, $node),
            new MustNotBeInCooldownRule($ship),
            new MustHavePowerRule($ship, 500)
        ];
    }
}
