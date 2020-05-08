<?php


namespace App\Service\Validation\Command\Validator;


use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

class RuleLocator
{
    private ServiceLocator $locator;

    public function __construct(ServiceLocator $locator)
    {

        $this->locator = $locator;
    }

    public function getRuleValidator(string $rule): RuleValidatorInterface
    {
        return $this->locator->get($rule . 'Validator');
    }
}
