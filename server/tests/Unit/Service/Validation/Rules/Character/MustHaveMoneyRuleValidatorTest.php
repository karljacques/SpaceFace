<?php

namespace App\Tests\Service\Validation\Rules\Character;

use App\Entity\Character;
use App\Service\Validation\Rules\Character\MustHaveMoneyRule;
use App\Service\Validation\Rules\Character\MustHaveMoneyRuleValidator;
use App\Service\Validation\Rules\RuleValidatorInterface;
use App\Tests\Unit\Service\Validation\Rules\AbstractRuleValidator;

class MustHaveMoneyRuleValidatorTest extends AbstractRuleValidator
{
    protected RuleValidatorInterface $validator;

    public function setUp(): void
    {
        $this->validator = new MustHaveMoneyRuleValidator();
    }

    public function testValidateSuccessful()
    {
        $character = $this->createCharacterWithMoney(1000);

        $rule = new MustHaveMoneyRule($character, 500);

        $this->assertTrue($this->validator->validate($rule));
    }

    /**
     * @param int $money
     * @return Character
     */
    protected function createCharacterWithMoney(int $money): Character
    {
        $character = new Character();
        $character->setMoney($money);
        return $character;
    }

    public function testValidateUnsuccessful()
    {
        $character = $this->createCharacterWithMoney(1000);

        $rule = new MustHaveMoneyRule($character, 5000);

        $this->assertFalse($this->validator->validate($rule));
    }

    public function testValidateWithExactMoney()
    {
        $character = $this->createCharacterWithMoney(1000);

        $rule = new MustHaveMoneyRule($character, 1000);

        $this->assertTrue($this->validator->validate($rule));
    }
}
