<?php

namespace App\Util;

class BoundingBox
{
    protected $start;
    protected $end;

    public function __construct(Vector2 $start, Vector2 $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function containsPoint(Vector2 $point): bool
    {
        if ($point->getX() < $this->start->getX()) {
            return false;
        }

        if ($point->getX() > $this->end->getX()) {
            return false;
        }

        if ($point->getY() < $this->start->getY()) {
            return false;
        }

        if ($point->getY() > $this->end->getY()) {
            return false;
        }

        return true;
    }
}
