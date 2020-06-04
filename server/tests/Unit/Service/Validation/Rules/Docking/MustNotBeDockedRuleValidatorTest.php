<?php

namespace App\Tests\Unit\Service\Validation\Rules\Docking;

use App\Entity\Dockable;
use App\Entity\Ship;
use App\Service\Validation\Rules\Docking\MustNotBeDockedRule;
use App\Service\Validation\Rules\Docking\MustNotBeDockedRuleValidator;
use App\Tests\Unit\Service\Validation\Rules\AbstractRuleValidator;

class MustNotBeDockedRuleValidatorTest extends AbstractRuleValidator
{
    public function setUp(): void
    {
        $this->validator = new MustNotBeDockedRuleValidator();
    }

    public function testValidateNotDocked()
    {
        $ship = new Ship();

        $rule = new MustNotBeDockedRule($ship);

        $this->assertTrue($this->validator->validate($rule));
    }

    public function testValidateDocked()
    {
        $ship = new Ship();
        $dockable = new Dockable();
        $ship->setDockedAt($dockable);

        $rule = new MustNotBeDockedRule($ship);

        $this->assertFalse($this->validator->validate($rule));
    }
}
