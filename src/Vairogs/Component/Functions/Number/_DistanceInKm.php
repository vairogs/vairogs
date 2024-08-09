<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Number;

use function asin;
use function cos;
use function deg2rad;
use function sin;
use function sqrt;

trait _DistanceInKm
{
    public static function distanceInKm(
        float $latitude1,
        float $longitude1,
        float $latitude2,
        float $longitude2,
    ): float {
        $earthRadius = 6371;

        $distanceLat = deg2rad(num: $latitude2 - $latitude1);
        $distanceLon = deg2rad(num: $longitude2 - $longitude1);

        $calculateDistance = 2 * asin(num: sqrt(num: sin(num: $distanceLat / 2) * sin(num: $distanceLat / 2) + cos(num: deg2rad(num: $latitude1)) * cos(num: deg2rad(num: $latitude2)) * sin(num: $distanceLon / 2) * sin(num: $distanceLon / 2)));

        return $earthRadius * $calculateDistance;
    }
}
