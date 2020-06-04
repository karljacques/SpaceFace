<?php

namespace App\Tests\Unit\Service\Validation\Rules\Docking;

use App\Entity\Dockable;
use App\Entity\Ship;
use App\Service\Validation\Rules\Docking\MustBeDockedRule;
use App\Service\Validation\Rules\Docking\MustBeDockedRuleValidator;
use App\Tests\Unit\Service\Validation\Rules\AbstractRuleValidator;

class MustBeDockedRuleValidatorTest extends AbstractRuleValidator
{
    public function setUp(): void
    {
        $this->validator = new MustBeDockedRuleValidator();
    }

    public function testValidateNotDocked()
    {
        $ship = new Ship();

        $rule = new MustBeDockedRule($ship);

        $this->assertFalse($this->validator->validate($rule));
    }

    public function testValidateDocked()
    {
        $ship = new Ship();
        $dockable = new Dockable();
        $ship->setDockedAt($dockable);

        $rule = new MustBeDockedRule($ship);

        $this->assertTrue($this->validator->validate($rule));
    }
}
