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

use RuntimeException;
use Vairogs\Component\Functions\Handler\SkipErrorHandler;

use function is_array;
use function preg_last_error;
use function sprintf;

use const PCRE_VERSION;

trait _NewPregException
{
    public static function newPregException(
        int $error,
        string $errorMsg,
        string $method,
        array|string $pattern,
    ): RuntimeException {
        $match = new class {
            use _Match;
            use _Replace;
        };
        $processPattern = static function (string $pattern) use ($error, $errorMsg, $method, $match): RuntimeException {
            $errorMessage = null;

            try {
                $result = SkipErrorHandler::execute(static fn () => $match::match($pattern, ''));
            } catch (RuntimeException $e) {
                $result = false;
                $errorMessage = $e->getMessage();
            }

            if (false !== $result) {
                return new RuntimeException(sprintf('Unknown error occurred when calling %s: %s.', $method, $errorMsg), $error);
            }

            $code = preg_last_error();

            $message = sprintf(
                '(code: %d) %s',
                $code,
                $match::replace('~preg_[a-z_]+[()]{2}: ~', '', $errorMessage),
            );

            return new RuntimeException(
                sprintf('%s(): Invalid PCRE pattern "%s": %s (version: %s)', $method, $pattern, $message, PCRE_VERSION),
                $code,
            );
        };

        if (is_array($pattern)) {
            $exceptions = [];

            foreach ($pattern as $singlePattern) {
                $exceptions[] = $processPattern($singlePattern);
            }

            $combinedMessage = implode("\n", array_map(static fn ($e) => $e->getMessage(), $exceptions));

            return new RuntimeException($combinedMessage, $error);
        }

        return $processPattern($pattern);
    }
}
