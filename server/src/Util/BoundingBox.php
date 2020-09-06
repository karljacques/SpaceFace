<?php

namespace App\Util;

class BoundingBox
{
    protected $start;
    protected $end;

    public function __construct(HexVector $start, HexVector $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return HexVector
     */
    public function getStart(): HexVector
    {
        return $this->start;
    }

    /**
     * @return HexVector
     */
    public function getEnd(): HexVector
    {
        return $this->end;
    }


    public function containsPoint(HexVector $point): bool
    {
        if ($point->getQ() < $this->start->getQ()) {
            return false;
        }

        if ($point->getQ() > $this->end->getQ()) {
            return false;
        }

        if ($point->getR() < $this->start->getR()) {
            return false;
        }

        if ($point->getR() > $this->end->getR()) {
            return false;
        }

        return true;
    }
}
