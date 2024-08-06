<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use JsonException;
use Vairogs\Component\Functions\Iteration;

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
        int $flags = Iteration::OBJECT,
    ): string {
        $flags = (JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | (Iteration::OBJECT !== ($flags & Iteration::PRETTY) ? JSON_PRETTY_PRINT : Iteration::OBJECT) | (defined(constant_name: 'JSON_PRESERVE_ZERO_FRACTION') ? JSON_PRESERVE_ZERO_FRACTION : Iteration::OBJECT));

        return json_encode(value: $value, flags: $flags | JSON_THROW_ON_ERROR);
    }
}
