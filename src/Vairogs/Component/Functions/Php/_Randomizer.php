<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

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
