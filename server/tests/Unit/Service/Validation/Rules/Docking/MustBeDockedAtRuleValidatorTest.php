<?php

namespace App\Tests\Unit\Service\Validation\Rules\Docking;

use App\Entity\Dockable;
use App\Entity\Ship;
use App\Service\Validation\Rules\Docking\MustBeDockedAtRule;
use App\Service\Validation\Rules\Docking\MustBeDockedAtRuleValidator;
use App\Tests\Unit\Service\Validation\Rules\AbstractRuleValidator;

class MustBeDockedAtRuleValidatorTest extends AbstractRuleValidator
{
    public function setUp(): void
    {
        $this->validator = new MustBeDockedAtRuleValidator();
    }

    public function testValidateNotDocked()
    {
        $expectedDockable = new Dockable();
        $ship = new Ship();

        $rule = new MustBeDockedAtRule($ship, $expectedDockable);

        $this->assertFalse($this->validator->validate($rule));
    }

    public function testValidateDocked()
    {
        $expectedDockable = new Dockable();
        $ship = new Ship();
        $ship->setDockedAt($expectedDockable);

        $rule = new MustBeDockedAtRule($ship, $expectedDockable);

        $this->assertTrue($this->validator->validate($rule));
    }

    public function testValidateDockedElseWhere()
    {
        $expectedDockable = new Dockable();
        $otherDockable = new Dockable();

        $ship = new Ship();
        $ship->setDockedAt($otherDockable);

        $rule = new MustBeDockedAtRule($ship, $expectedDockable);

        $this->assertFalse($this->validator->validate($rule));
    }
}
