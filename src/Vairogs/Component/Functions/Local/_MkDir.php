<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Local;

use UnexpectedValueException;

use function is_dir;
use function mkdir;
use function sprintf;

trait _MkDir
{
    /** @noinspection MkdirRaceConditionInspection */
    public function mkdir(
        string $dir,
    ): bool {
        if (!is_dir(filename: $dir)) {
            @mkdir(directory: $dir, recursive: true);
            if (!is_dir(filename: $dir)) {
                throw new UnexpectedValueException(message: sprintf('Directory "%s" was not created', $dir));
            }
        }

        return is_dir(filename: $dir);
    }
}
