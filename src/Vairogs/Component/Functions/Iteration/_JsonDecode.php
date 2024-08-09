<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Iteration;

use JsonException;
use Vairogs\Component\Functions\Iteration;

use function function_exists;
use function json_decode;
use function json_last_error;
use function json_last_error_msg;
use function json_validate;

use const JSON_BIGINT_AS_STRING;
use const JSON_THROW_ON_ERROR;

trait _JsonDecode
{
    /**
     * @throws JsonException
     */
    public function jsonDecode(
        string $json,
        int $flags = Iteration::OBJECT,
        int $depth = 512,
    ): mixed {
        $flags |= JSON_BIGINT_AS_STRING;
        if (function_exists(function: 'json_validate') && !json_validate(json: $json, depth: $depth, flags: $flags | JSON_THROW_ON_ERROR)) {
            throw new JsonException(message: json_last_error_msg(), code: json_last_error());
        }

        return json_decode(json: $json, associative: (bool) ($flags & Iteration::FORCE_ARRAY), depth: $depth, flags: $flags | JSON_THROW_ON_ERROR);
    }
}
