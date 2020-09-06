<?php

namespace App\Tests\Unit\Util;

use App\Util\HexVector;
use Generator;
use PHPUnit\Framework\TestCase;

class HexVectorTest extends TestCase
{
    public function testInstantiation()
    {
        $vector = new HexVector(12, 34);

        $this->assertEquals(12, $vector->getQ());
        $this->assertEquals(34, $vector->getR());
    }

    public function testAddition()
    {
        $a = new HexVector(3, 4);
        $b = new HexVector(5, 6);

        $c = $a->add($b);

        $this->assertEquals(8, $c->getQ());
        $this->assertEquals(10, $c->getR());
    }

    public function testSubtraction()
    {
        $a = new HexVector(5, 5);
        $b = new HexVector(2, 1);

        $c = $a->subtract($b);

        $this->assertEquals(3, $c->getQ());
        $this->assertEquals(4, $c->getR());
    }

    public function distanceProvider(): Generator
    {
        yield [new HexVector(0, 0), new HexVector(0, 0), 0];

        yield [new HexVector(-1, 0), new HexVector(2, -2), 3];
        yield [new HexVector(-1, 3), new HexVector(0, -4), 7];
    }

    /**
     * @dataProvider distanceProvider
     * @param HexVector $start
     * @param HexVector $end
     * @param int $distance
     */
    public function testDistance(HexVector $start, HexVector $end, int $distance)
    {
        $this->assertEquals($distance, $start->distance($end));
    }

    public function isAdjacentProvider(): Generator
    {
        yield [new HexVector(2, -1), new HexVector(1, 0), true];
        yield [new HexVector(2, -1), new HexVector(2, 0), true];

        yield [new HexVector(2, -1), new HexVector(3, 0), false];
    }

    /**
     * @dataProvider isAdjacentProvider
     * @param HexVector $start
     * @param HexVector $end
     * @param bool $isAdjacent
     */
    public function testIsAdjacent(HexVector $start, HexVector $end, bool $isAdjacent)
    {
        $this->assertEquals($isAdjacent, $start->isAdjacentTo($end));
    }
}
