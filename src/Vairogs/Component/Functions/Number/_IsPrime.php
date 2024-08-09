<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Number;

use Vairogs\Component\Functions\Handler\FunctionHandler;

trait _IsPrime
{
    public function isPrime(
        int $number,
        bool $override = false,
    ): bool {
        $function = (new FunctionHandler(function: 'isPrimal', instance: new class {
            use _IsPrimal;
        }));
        $below = (new FunctionHandler(function: 'isPrimeBelow1000', instance: new class {
            use _IsPrimeBelow1000;
        }))->next(handler: $function);

        return (bool) (new FunctionHandler(function: 'isPrimeGmp', instance: new class {
            use _IsPrimeGmp;
        }))->next(handler: $below)->handle($number, $override);
    }
}
