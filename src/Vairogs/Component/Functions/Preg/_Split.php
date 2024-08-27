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
use function preg_split;

use const PREG_NO_ERROR;

trait _Split
{
    public function split(
        string $pattern,
        string $subject,
        int $limit = -1,
        int $flags = 0,
    ): array {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _AddUtf8Modifier;
                use _NewPregException;
                use _RemoveUtf8Modifier;
            };
        }

        $result = @preg_split($_helper->addUtf8Modifier($pattern), $subject, $limit, $flags);

        if (false !== $result && PREG_NO_ERROR === preg_last_error()) {
            return $result;
        }

        $result = @preg_split($_helper->removeUtf8Modifier($pattern), $subject, $limit, $flags);

        if (false !== $result && PREG_NO_ERROR === preg_last_error()) {
            return $result;
        }

        throw $_helper->newPregException(preg_last_error(), preg_last_error_msg(), __METHOD__, $pattern);
    }
}
