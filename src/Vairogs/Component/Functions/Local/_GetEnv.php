<?php declare(strict_types = 1);

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
