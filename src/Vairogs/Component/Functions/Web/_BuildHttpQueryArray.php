<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use ReflectionException;
use Vairogs\Component\Functions\Php;

use function sprintf;

trait _BuildHttpQueryArray
{
    /**
     * @throws ReflectionException
     */
    public function buildHttpQueryArray(
        array|object $input,
        ?string $parent = null,
    ): array {
        $result = [];

        foreach ((new class() {
            use Php\_Array;
        })->array(input: $input) as $key => $value) {
            $newKey = match ($parent) {
                null => $key,
                default => sprintf('%s[%s]', $parent, $key),
            };

            $result = (new class() {
                use _Result;
            })->result(result: $result, key: $newKey, value: $value);
        }

        return $result;
    }
}
