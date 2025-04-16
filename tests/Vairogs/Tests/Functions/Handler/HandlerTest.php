<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Tests\Functions\Handler;

use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Vairogs\Assets\DataProvider\Functions\Handler\HandlerDataProvider;
use Vairogs\Functions\Handler\AbstractHandler;
use Vairogs\Functions\Handler\Chain;
use Vairogs\Functions\Handler\FunctionHandler;

class HandlerTest extends TestCase
{
    public function testAbstractHandlerWithNext(): void
    {
        $handler1 = new class extends AbstractHandler {
        };

        $handler2 = new class extends AbstractHandler {
            public function handle(
                ...$arguments,
            ): mixed {
                return $arguments[0] . '_modified';
            }
        };

        $handler1->next($handler2);
        $this->assertSame('test_modified', $handler1->handle('test'));
    }

    public function testAbstractHandlerWithoutNext(): void
    {
        $handler = new class extends AbstractHandler {
        };

        $this->assertNull($handler->handle('test'));
    }

    public function testChainConstruction(): void
    {
        $chain = new Chain('test');
        $this->assertSame('test', $chain->get());
    }

    public function testChainOf(): void
    {
        $chain = Chain::of('test');
        $this->assertSame('test', $chain->get());
    }

    #[DataProviderExternal(HandlerDataProvider::class, 'provideChainOperations')]
    public function testChainOperations(
        mixed $initialValue,
        array $operations,
        mixed $expectedResult,
    ): void {
        $chain = Chain::of($initialValue);

        foreach ($operations as $operation) {
            $chain = $chain->pipe($operation);
        }
        $this->assertSame($expectedResult, $chain->get());
    }

    #[DataProviderExternal(HandlerDataProvider::class, 'provideFunctionHandlerGlobalFunctions')]
    public function testFunctionHandlerWithGlobalFunction(
        string $function,
        mixed $input,
        mixed $expectedResult,
    ): void {
        $handler = new FunctionHandler($function);
        $this->assertSame($expectedResult, $handler->handle($input));
    }

    public function testFunctionHandlerWithNextHandler(): void
    {
        $handler1 = new FunctionHandler('strtoupper');
        $handler2 = new FunctionHandler('strrev');

        $handler1->next($handler2);
        $this->assertSame('tset', $handler1->handle('test'));
    }

    public function testFunctionHandlerWithNonExistentFunction(): void
    {
        $handler = new FunctionHandler('nonexistentFunction');
        $this->assertNull($handler->handle('test'));
    }

    public function testFunctionHandlerWithObjectMethod(): void
    {
        $object = new class {
            public function transform(
                string $input,
            ): string {
                return strrev($input);
            }
        };

        $handler = new FunctionHandler('transform', $object);
        $this->assertSame('tset', $handler->handle('test'));
    }
}
