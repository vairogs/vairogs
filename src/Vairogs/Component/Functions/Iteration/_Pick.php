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

use Vairogs\Component\Functions\Local;
use Vairogs\Component\Functions\Php;

use function array_rand;

trait _Pick
{
    public function pick(
        array $array,
    ): int|string|array {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use Local\_IsInstalled;
                use Php\_Randomizer;
            };
        }

        if ($_helper->isInstalled(packages: ['random'])) {
            return $_helper->randomizer()->pickArrayKeys(array: $array, num: 1)[0];
        }

        return array_rand(array: $array);
    }
}
