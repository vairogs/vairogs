<?php declare(strict_types = 1);

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
