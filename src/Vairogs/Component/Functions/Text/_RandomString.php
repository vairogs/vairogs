<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use Vairogs\Component\Functions\Text;

use function ceil;
use function str_repeat;
use function strlen;
use function substr;

trait _RandomString
{
    public function randomString(int $length = 32, string $chars = Text::BASIC): string
    {
        return substr(string: (new class() {
            use _Shuffle;
        })->shuffle(string: str_repeat(string: $chars, times: (int) ceil(num: (int) (strlen(string: $chars) / $length)))), offset: 0, length: $length);
    }
}
