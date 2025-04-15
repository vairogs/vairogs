<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Handler;

use Vairogs\Functions\Php;

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
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use Php\Traits\_ReturnFunction;
                use Php\Traits\_ReturnObject;
            };
        }

        if (!is_object(value: $this->instance)) {
            return $_helper->returnFunction($this->function, ...$arguments) ?? parent::handle(...$arguments);
        }

        return $_helper->returnObject($this->instance, $this->function, ...$arguments) ?? parent::handle(...$arguments);
    }
}
