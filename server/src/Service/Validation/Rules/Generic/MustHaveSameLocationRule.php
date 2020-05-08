<?php


namespace App\Service\Validation\Rules\Generic;


use App\Entity\Locatable;
use App\Service\Validation\Rules\RuleInterface;

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

    /**
     * @return Locatable
     */
    public function getA(): Locatable
    {
        return $this->a;
    }

    /**
     * @return Locatable
     */
    public function getB(): Locatable
    {
        return $this->b;
    }


}
