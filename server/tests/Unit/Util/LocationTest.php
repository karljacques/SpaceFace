<?php


use App\Entity\System;
use App\Util\HexVector;
use App\Util\Location;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testLocationsEquals()
    {
        $system = new System();
        $system->setId(1);

        $vector = new HexVector(1, 1);
        $vector2 = new HexVector(1, 1);

        $a = new Location($system, $vector);
        $b = new Location($system, $vector2);

        $this->assertTrue($a->equals($b));
        $this->assertTrue($b->equals($a));
    }

    public function testLocationNotEquals()
    {
        $system_2 = new System();
        $system_2->setId(2);

        $system_1 = new System();
        $system_1->setId(1);

        $vector = new HexVector(2, 2);

        $a = new Location($system_1, $vector);
        $b = new Location($system_2, $vector);

        $this->assertFalse($a->equals($b));
        $this->assertFalse($b->equals($a));
    }

    public function testLocationNotEqualsSameSystem()
    {
        $system = new System();
        $system->setId(1);

        $vectorA = new HexVector(1, 2);
        $vectorB = new HexVector(1, 3);

        $a = new Location($system, $vectorA);
        $b = new Location($system, $vectorB);

        $this->assertFalse($a->equals($b));
        $this->assertFalse($b->equals($a));
    }
}
