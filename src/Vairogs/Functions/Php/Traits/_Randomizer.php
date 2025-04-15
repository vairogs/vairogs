<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Php\Traits;

use Random\Engine\Xoshiro256StarStar;
use Random\Randomizer;

use function hash;
use function time;

trait _Randomizer
{
    public function randomizer(): Randomizer
    {
        return new Randomizer(engine: new Xoshiro256StarStar(seed: hash(algo: 'xxh128', data: (string) time(), binary: true)));
    }
}
