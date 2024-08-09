<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use Vairogs\Component\Functions\Local;
use Vairogs\Component\Functions\Php;

use function array_rand;

trait _Pick
{
    public function pick(
        array $array,
    ): int|string|array {
        if ((new class {
            use Local\_IsInstalled;
        })->isInstalled(packages: ['random'])) {
            return (new class {
                use Php\_Randomizer;
            })->randomizer()->pickArrayKeys(array: $array, num: 1)[0];
        }

        return array_rand(array: $array);
    }
}
