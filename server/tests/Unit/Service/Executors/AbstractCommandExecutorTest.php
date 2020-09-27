<?php

namespace App\Tests\Unit\Service\Executors;


use App\Command\CommandInterface;
use App\Exception\UserActionException;
use App\Service\Executors\AbstractCommandExecutor;
use App\Service\Validation\Rules\Docking\MustBeDockedRule;
use App\Service\Validation\Rules\Storage\MustHaveStorageSpaceRule;
use App\Service\Validation\Rules\System\MustBeWithinSystemRule;
use App\Service\Validation\Rules\System\MustBeWithinSystemRuleValidator;
use App\Service\Validation\RuleValidatorLocator;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class AbstractCommandExecutorTest extends TestCase
{
    /**
     * @throws UserActionException
     */
    public function testExecuteNoRuleViolations()
    {
        $commandExecutor = $this->getCommandExecutor();
        $command = $this->createMock(CommandInterface::class);

        $rules = list($rule1, $rule2, $rule3) = $this->getRules();
        $command->expects($this->any())->method('getValidationRules')->willReturn($rules);

        $ruleValidatorLocator = $this->mockGetRuleValidator($commandExecutor);

        $ruleValidator1 = $this->mockGetValidator($ruleValidatorLocator, $rule1);
        $ruleValidator2 = $this->mockGetValidator($ruleValidatorLocator, $rule2);
        $ruleValidator3 = $this->mockGetValidator($ruleValidatorLocator, $rule3);

        $ruleValidator1->validate($rule1)->shouldBeCalled()->willReturn(true);
        $ruleValidator2->validate($rule2)->shouldBeCalled()->willReturn(true);
        $ruleValidator3->validate($rule3)->shouldBeCalled()->willReturn(true);

        $commandExecutor->expects($this->once())
            ->method('executeCommand');

        $entityManager = $this->mockGetEntityManager($commandExecutor);
        $entityManager->flush()->shouldBeCalled();

        $commandExecutor->execute($command);
    }

    /**
     * @throws UserActionException
     */
    public function testExecuteExceptionThrowWhenViolations()
    {
        $commandExecutor = $this->getCommandExecutor();
        $command = $this->createMock(CommandInterface::class);

        $rules = list($rule1, $rule2, $rule3) = $this->getRules();
        $command->expects($this->any())->method('getValidationRules')->willReturn($rules);

        $ruleValidatorLocator = $this->mockGetRuleValidator($commandExecutor);

        $ruleValidator1 = $this->mockGetValidator($ruleValidatorLocator, $rule1);
        $ruleValidator2 = $this->mockGetValidator($ruleValidatorLocator, $rule2);
        $ruleValidator3 = $this->mockGetValidator($ruleValidatorLocator, $rule3);


        $ruleValidator1->validate($rule1)->shouldBeCalled()->willReturn(false);
        $ruleValidator2->validate($rule2)->shouldBeCalled()->willReturn(true);
        $ruleValidator3->validate($rule3)->shouldBeCalled()->willReturn(false);

        $commandExecutor->expects($this->never())->method('executeCommand');

        $this->expectException(UserActionException::class);

        $commandExecutor->execute($command);

    }

    /**
     * @return AbstractCommandExecutor|MockObject
     */
    protected function getCommandExecutor()
    {
        /** @var AbstractCommandExecutor|MockObject $commandExecutor */
        $commandExecutor = $this->createPartialMock(AbstractCommandExecutor::class, [
            'executeCommand',
            'ruleValidatorLocator',
            'entityManager'
        ]);
        return $commandExecutor;
    }

    /**
     * @return array
     */
    protected function getRules(): array
    {
        $rule1 = $this->createMock(MustBeWithinSystemRule::class);
        $rule2 = $this->createMock(MustBeDockedRule::class);
        $rule3 = $this->createMock(MustHaveStorageSpaceRule::class);

        return [
            $rule1,
            $rule2,
            $rule3
        ];
    }

    /**
     * @param $commandExecutor
     * @return RuleValidatorLocator|ObjectProphecy
     */
    protected function mockGetRuleValidator(MockObject $commandExecutor)
    {
        $ruleValidatorLocator = $this->prophesize(RuleValidatorLocator::class);
        $commandExecutor->expects($this->any())
            ->method('ruleValidatorLocator')
            ->willReturn($ruleValidatorLocator->reveal());

        return $ruleValidatorLocator;
    }

    /**
     * @param ObjectProphecy|RuleValidatorLocator $ruleValidatorLocator
     * @param $rule1
     * @return MustBeWithinSystemRuleValidator|ObjectProphecy
     */
    protected function mockGetValidator($ruleValidatorLocator, $rule1)
    {
        $ruleValidator = $this->prophesize(MustBeWithinSystemRuleValidator::class);

        $ruleValidatorLocator->getRuleValidator($rule1)
            ->willReturn($ruleValidator->reveal());

        return $ruleValidator;
    }

    /**
     * @param MockObject $commandExecutor
     * @return EntityManagerInterface|ObjectProphecy
     */
    protected function mockGetEntityManager(MockObject $commandExecutor)
    {
        $entityManager = $this->prophesize(EntityManagerInterface::class);

        $commandExecutor->expects($this->any())
            ->method('entityManager')
            ->willReturn($entityManager->reveal());

        return $entityManager;
    }
}
