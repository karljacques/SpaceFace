<?php

namespace App\Uni\Service\Validation\Rules\System;

use App\Entity\System;
use App\Service\Validation\Rules\System\MustBeWithinSystemRule;
use App\Service\Validation\Rules\System\MustBeWithinSystemRuleValidator;
use App\Tests\Unit\Service\Validation\Rules\AbstractRuleValidator;
use App\Util\Location;
use App\Util\Vector2;

class MustBeWithinSystemRuleValidatorTest extends AbstractRuleValidator
{
    public function setUp(): void
    {
        $this->validator = new MustBeWithinSystemRuleValidator();
    }

    public function testValidateInSystemBounds()
    {
        $system = new System();
        $system->setSizeX(10)
            ->setSizeY(10);

        $location = new Location($system, new Vector2(10, 10));
        $rule = new MustBeWithinSystemRule($location);

        $this->assertTrue($this->validator->validate($rule));
    }

    public function testValidateOutOfSystemBounds()
    {
        $system = new System();
        $system->setSizeX(10)
            ->setSizeY(10);

        $location = new Location($system, new Vector2(11, 10));
        $rule = new MustBeWithinSystemRule($location);

        $this->assertFalse($this->validator->validate($rule));
    }
}
