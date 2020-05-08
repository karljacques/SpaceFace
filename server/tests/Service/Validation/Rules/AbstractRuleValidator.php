<?php


namespace App\Tests\Service\Validation\Rules;


use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

abstract class AbstractRuleValidator extends TestCase
{
    protected RuleValidatorInterface $validator;

    public function testValidatorThrowsUnexpectedTypeException()
    {
        /** @var MockObject|RuleInterface $rule */
        $rule = $this->createMock(RuleInterface::class);

        $this->expectException(UnexpectedTypeException::class);
        $this->getValidator()->validate($rule);

    }

    public function getValidator(): RuleValidatorInterface
    {
        return $this->validator;
    }
}
