<?php

namespace App\Tests\Unit\Service\Validation\Rules\Ship;

use App\Entity\Ship;
use App\Service\Validation\Rules\Ship\MustHaveFuelRule;
use App\Service\Validation\Rules\Ship\MustHaveFuelRuleValidator;
use App\Tests\Unit\Service\Validation\Rules\AbstractRuleValidator;

class MustHaveFuelRuleValidatorTest extends AbstractRuleValidator
{
    public function setUp(): void
    {
        $this->validator = new MustHaveFuelRuleValidator();
    }

    public function testValidateHasEnoughFuel()
    {
        $rule = $this->createRule(200, 100);

        $this->assertTrue($this->validator->validate($rule));
    }

    /**
     * @param int $current
     * @param int $required
     * @return MustHaveFuelRule
     */
    protected function createRule(int $current, int $required): MustHaveFuelRule
    {
        $ship = new Ship();
        $ship->setFuel($current);

        return new MustHaveFuelRule($ship, $required);
    }

    public function testValidateHasExactFuel()
    {
        $rule = $this->createRule(200, 200);

        $this->assertTrue($this->validator->validate($rule));
    }

    public function testValidateNotEnoughFuel()
    {
        $rule = $this->createRule(100, 200);

        $this->assertFalse($this->validator->validate($rule));
    }

}
