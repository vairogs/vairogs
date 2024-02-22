<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions;

use Random\Engine\Xoshiro256StarStar;
use Random\Randomizer;

use function array_rand;
use function str_shuffle;

abstract class Abstraction
{
    protected bool $isSupported;

    public function __construct()
    {
        $this->isSupported = (new Composer())->isInstalled(packages: ['random']);
    }

    public function shuffle(string $string): string
    {
        if ($this->isSupported) {
            return (new Randomizer(engine: new Xoshiro256StarStar()))->shuffleBytes(bytes: $string);
        }

        return str_shuffle(string: $string);
    }

    public function pick(array $array): int|string|array
    {
        if ($this->isSupported) {
            return (new Randomizer(engine: new Xoshiro256StarStar()))->pickArrayKeys(array: $array, num: 1)[0];
        }

        return array_rand(array: $array);
    }
}
