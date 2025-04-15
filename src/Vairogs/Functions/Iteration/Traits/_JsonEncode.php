<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Iteration\Traits;

use JsonException;

use function defined;
use function json_encode;

use const JSON_PRESERVE_ZERO_FRACTION;
use const JSON_PRETTY_PRINT;
use const JSON_THROW_ON_ERROR;
use const JSON_UNESCAPED_SLASHES;
use const JSON_UNESCAPED_UNICODE;

trait _JsonEncode
{
    /**
     * @throws JsonException
     */
    public function jsonEncode(
        mixed $value,
        int $flags = 0,
    ): string {
        $flags = (JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | (0 !== ($flags & 0b0010) ? JSON_PRETTY_PRINT : 0) | (defined(constant_name: 'JSON_PRESERVE_ZERO_FRACTION') ? JSON_PRESERVE_ZERO_FRACTION : 0));

        return json_encode(value: $value, flags: $flags | JSON_THROW_ON_ERROR);
    }
}
