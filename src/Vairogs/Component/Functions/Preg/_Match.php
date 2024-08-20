<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Preg;

use function preg_last_error;
use function preg_last_error_msg;
use function preg_match;

use const PREG_NO_ERROR;

trait _Match
{
    public static function match(
        string $pattern,
        string $subject,
        ?array &$matches = null,
        int $flags = 0,
        int $offset = 0,
    ): bool {
        $result = @preg_match((new class {
            use _AddUtf8Modifier;
        })::addUtf8Modifier($pattern), $subject, $matches, $flags, $offset);
        if (false !== $result && PREG_NO_ERROR === preg_last_error()) {
            return 1 === $result;
        }

        $result = @preg_match((new class {
            use _RemoveUtf8Modifier;
        })::removeUtf8Modifier($pattern), $subject, $matches, $flags, $offset);
        if (false !== $result && PREG_NO_ERROR === preg_last_error()) {
            return 1 === $result;
        }

        throw (new class {
            use _NewPregException;
        })::newPregException(preg_last_error(), preg_last_error_msg(), __METHOD__, $pattern);
    }
}
