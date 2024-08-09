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

use function is_array;

trait _IsEmpty
{
    public function isEmpty(
        mixed $variable,
        bool $result = true,
    ): bool {
        if (is_array(value: $variable) && [] !== $variable) {
            foreach ($variable as $item) {
                $result = $this->isEmpty(variable: $item, result: $result);
            }

            return $result;
        }

        return empty($variable);
    }
}
