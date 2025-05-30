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

use function is_array;

trait _IsEmpty
{
    public function isEmpty(
        mixed $variable,
        bool $result = true,
    ): bool {
        if (is_array(value: $variable) && [] !== $variable) {
            static $_helper = null;

            if (null === $_helper) {
                $_helper = new class {
                    use _IsEmpty;
                };
            }

            foreach ($variable as $item) {
                $result = $_helper->isEmpty(variable: $item, result: $result);
            }

            return $result;
        }

        return empty($variable);
    }
}
