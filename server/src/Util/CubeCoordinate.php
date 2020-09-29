<?php


namespace App\Util;


class CubeCoordinate
{
    protected int $x;
    protected int $y;
    protected int $z;

    public function __construct(int $x, int $y, int $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function distance(CubeCoordinate $b): int
    {
        $a = $this;

        return max(
            abs($a->getX() - $b->getX()),
            abs($a->getY() - $b->getY()),
            abs($a->getZ() - $b->getZ())
        );
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getZ(): int
    {
        return $this->z;
    }
}
