<?php


namespace App\Service\Validation;


use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

class RuleValidatorLocator
{
    private ServiceLocator $locator;

    public function __construct(ServiceLocator $locator)
    {

        $this->locator = $locator;
    }

    public function getRuleValidator(RuleInterface $rule): RuleValidatorInterface
    {
        $ruleName = get_class($rule);

        return $this->locator->get($ruleName . 'Validator');
    }
}
