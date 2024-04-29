<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Number;

use function acos;
use function cos;
use function deg2rad;
use function rad2deg;
use function round;
use function sin;

trait _DistanceBetweenPoints
{
    public function distanceBetweenPoints(
        float $latitude1,
        float $longitude1,
        float $latitude2,
        float $longitude2,
        bool $km = true,
        int $precision = 4,
    ): float {
        if ($latitude1 === $latitude2 && $longitude1 === $longitude2) {
            return 0.0;
        }

        $lat1rad = deg2rad(num: $latitude1);
        $lat2rad = deg2rad(num: $latitude2);

        $distance = rad2deg(num: acos(num: (sin(num: $lat1rad) * sin(num: $lat2rad)) + (cos(num: $lat1rad) * cos(num: $lat2rad) * cos(num: deg2rad(num: $longitude1 - $longitude2)))));

        return round(num: $km ? $distance * 111.18957696 : $distance * 69.09, precision: $precision);
    }
}
