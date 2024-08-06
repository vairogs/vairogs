<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function explode;

trait _Unpack
{
    public function unpack(
        array $oneDimension,
    ): array {
        $multiDimension = [];

        foreach ($oneDimension as $key => $value) {
            $path = explode(separator: '.', string: $key);
            $temp = &$multiDimension;
            foreach ($path as $segment) {
                if (!isset($temp[$segment])) {
                    $temp[$segment] = [];
                }
                $temp = &$temp[$segment];
            }

            $temp = $value;
        }

        return $multiDimension;
    }
}
