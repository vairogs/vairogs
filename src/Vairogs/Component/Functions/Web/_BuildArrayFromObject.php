<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use ReflectionException;

use function parse_str;

trait _BuildArrayFromObject
{
    /**
     * @throws ReflectionException
     */
    public function buildArrayFromObject(
        object $object,
    ): array {
        parse_str(string: (new class {
            use _BuildHttpQueryString;
        })->buildHttpQueryString(object: $object), result: $result);

        return $result;
    }
}
