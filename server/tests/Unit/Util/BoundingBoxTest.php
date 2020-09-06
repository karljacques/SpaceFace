<?php


use App\Util\BoundingBox;
use App\Util\HexVector;
use PHPUnit\Framework\TestCase;

class BoundingBoxTest extends TestCase
{
    public function pointProvider()
    {
        yield [new HexVector(1, 1), true];
        yield [new HexVector(0, 0), false];
        yield [new HexVector(10, 10), true];
        yield [new HexVector(10, 11), false];
        yield [new HexVector(5, 5), true];
    }

    /**
     * @dataProvider pointProvider
     * @param HexVector $point
     * @param bool $inside
     */
    public function testContainsPoint(HexVector $point, bool $inside)
    {
        $box = new BoundingBox(new HexVector(1, 1), new HexVector(10, 10));

        $this->assertEquals($inside, $box->containsPoint($point));
    }
}
