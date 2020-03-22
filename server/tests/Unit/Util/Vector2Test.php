<?php


use App\Util\Vector2;
use PHPUnit\Framework\TestCase;

class Vector2Test extends TestCase
{
    public function testVector2Instantiation()
    {
        $vector = new Vector2(12, 34);

        $this->assertEquals(12, $vector->getX());
        $this->assertEquals(34, $vector->getY());
    }

    public function testVector2Addition()
    {
        $a = new Vector2(3, 4);
        $b = new Vector2(5, 6);

        $c = $a->add($b);

        $this->assertEquals(8, $c->getX());
        $this->assertEquals(10, $c->getY());
    }

    public function testVector2Subtraction()
    {
        $a = new Vector2(5,5);
        $b = new Vector2(2, 1);

        $c = $a->subtract($b);

        $this->assertEquals(3, $c->getX());
        $this->assertEquals(4, $c->getY());
    }
}
