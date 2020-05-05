<?php


namespace App\Service\Validator\Rules;


use App\Entity\Character;

class MustHaveMoneyRule implements RuleInterface
{
    /**
     * @var Character
     */
    private Character $character;
    /**
     * @var int
     */
    private int $requiredMoney;

    public function __construct(Character $character, int $requiredMoney)
    {
        $this->character = $character;
        $this->requiredMoney = $requiredMoney;
    }

    public function getViolationMessage(): string
    {
        return 'You do not have enough money for this transaction';
    }

    public function validate(): bool
    {
        return $this->character->getMoney() >= $this->requiredMoney;
    }
}
