<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use JsonException;
use Vairogs\Component\Functions\Iteration;

use function function_exists;
use function json_decode;
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
    ): mixed {
        if (function_exists(function: 'json_validate')) {
            json_validate(json: $json);
        }

        return json_decode(json: $json, associative: (bool) ($flags & Iteration::FORCE_ARRAY), depth: JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING, flags: $flags | JSON_THROW_ON_ERROR);
    }
}
