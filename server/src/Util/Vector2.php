<?php

namespace App\Util;

use JsonSerializable;
use Symfony\Component\Serializer\Annotation\Groups;

class Vector2 implements JsonSerializable
{
    protected $x;
    protected $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @Groups({"basic"})
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @Groups({"basic"})
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    public function add(Vector2 $a): Vector2
    {
        return new Vector2($this->getX() + $a->getX(), $this->getY() + $a->getY());
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'x' => $this->getX(),
            'y' => $this->getY()
        ];
    }

    public function subtract(Vector2 $b): Vector2
    {
        return new Vector2($this->getX() - $b->getX(), $this->getY() - $b->getY());
    }

    public function equals(Vector2 $vector): bool
    {
        return $this->x === $vector->getX() && $this->y === $vector->getY();
    }
}
