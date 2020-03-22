<?php


use App\Util\BoundingBox;
use App\Util\Vector2;
use PHPUnit\Framework\TestCase;

class BoundingBoxTest extends TestCase
{
    public function pointProvider()
    {
        yield [new Vector2(1, 1), true];
        yield [new Vector2(0, 0), false];
        yield [new Vector2(10, 10), true];
        yield [new Vector2(10, 11), false];
        yield [new Vector2(5, 5), true];
    }

    /**
     * @dataProvider pointProvider
     * @param Vector2 $point
     * @param bool $inside
     */
    public function testContainsPoint(Vector2 $point, bool $inside)
    {
        $box = new BoundingBox(new Vector2(1, 1), new Vector2(10, 10));

        $this->assertEquals($inside, $box->containsPoint($point));
    }
}
