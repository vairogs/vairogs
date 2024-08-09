<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Web;

use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Vairogs\Component\Functions\Iteration;
use Vairogs\Component\Functions\Php;

trait _RequestMethods
{
    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function requestMethods(): array
    {
        return (new class {
            use Iteration\_ArrayValuesFiltered;
        })->arrayValuesFiltered(input: (new class {
            use Php\_ClassConstants;
        })->classConstants(class: Request::class), with: 'METHOD_');
    }
}
