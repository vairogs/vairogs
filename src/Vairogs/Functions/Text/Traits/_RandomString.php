<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Text\Traits;

use Vairogs\Functions\Text\Functions;

use function ceil;
use function str_repeat;
use function strlen;
use function substr;

trait _RandomString
{
    public function randomString(
        int $length = 32,
        string $chars = Functions::BASIC,
    ): string {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _Shuffle;
            };
        }

        return substr(string: $_helper->shuffle(string: str_repeat(string: $chars, times: (int) ceil(num: (int) (strlen(string: $chars) / $length)))), offset: 0, length: $length);
    }
}
