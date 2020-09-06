<?php

namespace App\Util;

use JsonSerializable;
use Symfony\Component\Serializer\Annotation\Groups;

// https://www.redblobgames.com/grids/hexagons/
// Axial-Coordinate vector
class HexVector implements JsonSerializable
{
    protected int $q;
    protected int $r;

    public function __construct(int $q, int $z)
    {
        $this->q = $q;
        $this->r = $z;
    }

    public function add(HexVector $a): HexVector
    {
        return new HexVector($this->getQ() + $a->getQ(), $this->getR() + $a->getR());
    }

    /**
     * @Groups({"basic"})
     * @return int
     */
    public function getQ(): int
    {
        return $this->q;
    }

    /**
     * @Groups({"basic"})
     * @return int
     */
    public function getR(): int
    {
        return $this->r;
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
            'q' => $this->getQ(),
            'z' => $this->getR()
        ];
    }

    public function subtract(HexVector $b): HexVector
    {
        return new HexVector($this->getQ() - $b->getQ(), $this->getR() - $b->getR());
    }

    public function equals(HexVector $vector): bool
    {
        return $this->q === $vector->getQ() && $this->r === $vector->getR();
    }

    public function isAdjacentTo(HexVector $end): bool
    {
        return $this->distance($end) === 1;
    }

    public function distance(HexVector $end): int
    {
        $a = CoordinateConversion::axialToCube($this);
        $b = CoordinateConversion::axialToCube($end);

        return $a->distance($b);
    }
}
