<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Local;

use function getenv;

trait _GetEnv
{
    public function getenv(
        string $name,
        bool $localOnly = true,
    ): mixed {
        return getenv(name: $name, local_only: $localOnly) ?: ($_ENV[$name] ?? $name);
    }
}
