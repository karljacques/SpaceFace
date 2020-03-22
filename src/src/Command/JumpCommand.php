<?php


namespace App\Command;
use Symfony\Component\Validator\Constraints as Assert;


class JumpCommand implements CommandInterface
{
    /** @var  int
        @Assert\Positive
     */
    private $targetSystem;

    public static function createFromArray($arr): self
    {
        $move = new self;
        $move->targetSystem = $arr['targetSystem'];

        return $move;
    }
}
