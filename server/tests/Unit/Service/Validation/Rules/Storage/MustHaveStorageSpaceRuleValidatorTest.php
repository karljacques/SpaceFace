<?php

namespace App\Tests\Unit\Service\Validation\Rules\Storage;

use App\Entity\Component\Storage;
use App\Service\Validation\Rules\Storage\MustHaveStorageSpaceRule;
use App\Service\Validation\Rules\Storage\MustHaveStorageSpaceRuleValidator;
use App\Tests\Unit\Service\Validation\Rules\AbstractRuleValidator;

class MustHaveStorageSpaceRuleValidatorTest extends AbstractRuleValidator
{
    public function setUp(): void
    {
        $this->validator = new MustHaveStorageSpaceRuleValidator();
    }

    public function testValidateEnoughStorage()
    {
        $rule = $this->createRule(100, 50);
        $this->assertTrue($this->validator->validate($rule));
    }

    public function createRule(int $available, int $required): MustHaveStorageSpaceRule
    {
        $storage = new Storage();
        $storage->setCapacity($available);

        return new MustHaveStorageSpaceRule($storage, $required);
    }

    public function testValidateExactStorage()
    {
        $rule = $this->createRule(100, 100);
        $this->assertTrue($this->validator->validate($rule));
    }

    public function testValidateNotEnoughStorage()
    {
        $rule = $this->createRule(100, 500);
        $this->assertFalse($this->validator->validate($rule));
    }
}
