<?php


namespace App\Util;


class CoordinateConversion
{
    public static function cubeToAxial(CubeCoordinate $cube): HexVector
    {
        $q = $cube->getX();
        $r = $cube->getZ();

        return new HexVector($q, $r);
    }

    public static function axialToCube(HexVector $vector): CubeCoordinate
    {
        $x = $vector->getQ();
        $z = $vector->getR();
        $y = -$x - $z;

        return new CubeCoordinate($x, $y, $z);
    }
}
