<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Handler;

use Vairogs\Component\Functions\Php;

use function is_object;

class FunctionHandler extends AbstractHandler
{
    public function __construct(
        private readonly string $function,
        private readonly ?object $instance = null,
    ) {
    }

    public function handle(
        ...$arguments,
    ): mixed {
        if (!is_object(value: $this->instance)) {
            return (new class {
                use Php\_ReturnFunction;
            })->returnFunction($this->function, ...$arguments) ?? parent::handle(...$arguments);
        }

        return (new class {
            use Php\_ReturnObject;
        })->returnObject($this->instance, $this->function, ...$arguments) ?? parent::handle(...$arguments);
    }
}
