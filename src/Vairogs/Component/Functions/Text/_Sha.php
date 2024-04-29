<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function base64_encode;
use function hash;
use function round;
use function rtrim;
use function substr;

trait _Sha
{
    public function sha(string $text, int $bits = 256): string
    {
        $hash = substr(string: hash(algo: 'sha' . $bits, data: $text, binary: true), offset: 0, length: (int) round(num: $bits / 16));

        return strtr(rtrim(string: base64_encode(string: $hash), characters: '='), from: '+/', to: '-_');
    }
}
