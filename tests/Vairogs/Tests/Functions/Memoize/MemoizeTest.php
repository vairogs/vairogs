<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Tests\Functions\Memoize;

use BackedEnum;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Vairogs\Assets\Functions\Memoize\DataProvider\MemoizeDataProvider;
use Vairogs\Functions\Memoize\Memoize;

class MemoizeTest extends TestCase
{
    #[DataProviderExternal(MemoizeDataProvider::class, 'provideMemoizeMethod')]
    public function testMemoize(
        BackedEnum $context,
        int|string $key,
        ?callable $callback,
        bool $refresh,
        array $subKeys,
        ?string $expectedResult,
        ?string $expectedSecondCallResult,
    ): void {
        $memoize = new Memoize();

        // Test memoize method
        $result = $memoize->memoize($context, $key, $callback, $refresh, ...$subKeys);

        if (null === $expectedResult) {
            $this->assertNotNull($result);
        } else {
            $this->assertSame($expectedResult, $result);
        }

        // Test second call to memoize method
        $secondResult = $memoize->memoize($context, $key, $callback, $refresh, ...$subKeys);

        if (null === $expectedSecondCallResult) {
            $this->assertNotNull($secondResult);

            if ($refresh) {
                $this->assertNotSame($result, $secondResult);
            } else {
                $this->assertSame($result, $secondResult);
            }
        } else {
            $this->assertSame($expectedSecondCallResult, $secondResult);
        }
    }

    #[DataProviderExternal(MemoizeDataProvider::class, 'provideValueMethod')]
    public function testValue(
        BackedEnum $context,
        int|string $key,
        ?callable $callback,
        bool $refresh,
        array $subKeys,
        ?string $expectedResult,
        ?string $expectedSecondCallResult,
        ?string $defaultValue = null,
    ): void {
        $memoize = new Memoize();

        if (null !== $callback) {
            // First, store a value using memoize method
            $memoize->memoize($context, $key, $callback, $refresh, ...$subKeys);
        }

        // Then test the value method
        $result = $memoize->value($context, $key, $defaultValue, ...$subKeys);

        if (null === $expectedResult) {
            $this->assertNotNull($result);
        } else {
            $this->assertSame($expectedResult, $result);
        }

        // Test second call to value method
        $secondResult = $memoize->value($context, $key, $defaultValue, ...$subKeys);

        if (null === $expectedSecondCallResult) {
            $this->assertNotNull($secondResult);
            $this->assertSame($result, $secondResult);
        } else {
            $this->assertSame($expectedSecondCallResult, $secondResult);
        }
    }
}
