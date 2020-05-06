<?php


namespace App\Service\Validation\Rules\Character;


use App\Entity\Character;
use App\Service\Validation\Rules\RuleInterface;

class MustHaveMoneyRule implements RuleInterface
{
    private Character $character;
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

    /**
     * @return Character
     */
    public function getCharacter(): Character
    {
        return $this->character;
    }

    /**
     * @return int
     */
    public function getRequiredMoney(): int
    {
        return $this->requiredMoney;
    }
}
