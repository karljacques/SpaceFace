<?php


namespace App\Command;


use App\Service\Validation\Rules\Docking\MustBeDockedRule;
use App\Service\Validation\Rules\Ship\MustHavePowerRule;
use App\Service\Validation\Rules\Ship\MustNotBeInCooldownRule;

class UndockCommand extends AbstractShipCommand
{
    public function getValidationRules(): array
    {
        return [
            new MustBeDockedRule($this->ship),
            new MustNotBeInCooldownRule($this->ship),
            new MustHavePowerRule($this->ship, 100),
        ];
    }
}
