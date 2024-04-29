<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Number;

use Vairogs\Component\Functions\Handler\FunctionHandler;

trait _IsPrime
{
    public function isPrime(
        int $number,
        bool $override = false,
    ): bool {
        $function = (new FunctionHandler(function: 'isPrimal', instance: new class() {
            use _IsPrimal;
        }));
        $below = (new FunctionHandler(function: 'isPrimeBelow1000', instance: new class() {
            use _IsPrimeBelow1000;
        }))->next(handler: $function);

        return (bool) (new FunctionHandler(function: 'isPrimeGmp', instance: new class() {
            use _IsPrimeGmp;
        }))->next(handler: $below)->handle($number, $override);
    }
}
