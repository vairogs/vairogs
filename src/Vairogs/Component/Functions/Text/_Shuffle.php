<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use Vairogs\Component\Functions\Local;
use Vairogs\Component\Functions\Php;

use function str_shuffle;

trait _Shuffle
{
    public function shuffle(string $string): string
    {
        if ((new class {
            use Local\_IsInstalled;
        })->isInstalled(packages: ['random'])) {
            return (new class {
                use Php\_Randomizer;
            })->randomizer()->shuffleBytes(bytes: $string);
        }

        return str_shuffle(string: $string);
    }
}
