<?php


namespace App\Service\Validator\Rules;


use App\Entity\Locatable;

class MustHaveSameLocationRule implements RuleInterface
{
    /**
     * @var Locatable
     */
    private Locatable $a;
    /**
     * @var Locatable
     */
    private Locatable $b;

    public function __construct(Locatable $a, Locatable $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function getViolationMessage(): string
    {
        return 'Not in same location';
    }

    public function validate(): bool
    {
        return $this->a->getLocation()->equals($this->b->getLocation());
    }
}
