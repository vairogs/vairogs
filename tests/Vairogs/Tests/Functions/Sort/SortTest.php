<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Tests\Functions\Sort;

use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Vairogs\Assets\Functions\Sort\DataProvider\SortDataProvider;
use Vairogs\Functions\Sort\Traits\_BubbleSort;
use Vairogs\Functions\Sort\Traits\_MergeSort;
use Vairogs\Functions\Sort\Traits\_SortByParameter;
use Vairogs\Functions\Sort\Traits\_StableSort;
use Vairogs\Functions\Sort\Traits\_Usort;

class SortTest extends TestCase
{
    #[DataProviderExternal(SortDataProvider::class, 'provideBubbleSortMethod')]
    public function testBubbleSort(
        array $array,
        array $expectedResult,
    ): void {
        $originalArray = $array;
        new class {
            use _BubbleSort;
        }->bubbleSort($array);
        $this->assertEquals($expectedResult, $array);

        // Only check for modification if the original array was not already sorted
        if (!empty($originalArray) && $originalArray !== $expectedResult) {
            $this->assertNotEquals($originalArray, $array, 'Array should be modified in place');
        }
    }

    #[DataProviderExternal(SortDataProvider::class, 'provideMergeSortMethod')]
    public function testMergeSort(
        array $array,
        array $expectedResult,
    ): void {
        $originalArray = $array;
        $result = new class {
            use _MergeSort;
        }->mergeSort($array);
        $this->assertEquals($expectedResult, $result);
        $this->assertEquals($originalArray, $array, 'Original array should not be modified');
    }

    #[DataProviderExternal(SortDataProvider::class, 'provideSortByParameterMethod')]
    public function testSortByParameter(
        array|object $data,
        string $parameter,
        string $order,
        ?array $expectedResult,
        ?string $expectedException,
    ): void {
        if (null !== $expectedException) {
            $this->expectException($expectedException);
        }

        $result = new class {
            use _SortByParameter;
        }->sortByParameter($data, $parameter, $order);

        if (null === $expectedException) {
            $this->assertEquals($expectedResult, $result);
        }
    }

    #[DataProviderExternal(SortDataProvider::class, 'provideStableSortMethod')]
    public function testStableSort(
        array $elements,
        callable $getComparedValue,
        callable $compareValues,
        array $expectedResult,
    ): void {
        $result = new class {
            use _StableSort;
        }->stableSort($elements, $getComparedValue, $compareValues);
        $this->assertEquals($expectedResult, $result);
    }

    #[DataProviderExternal(SortDataProvider::class, 'provideUsortMethod')]
    public function testUsort(
        string $parameter,
        string $order,
        array|object $first,
        array|object $second,
        int $expectedResult,
    ): void {
        $callback = new class {
            use _Usort;
        }->usort($parameter, $order);
        $result = $callback($first, $second);
        $this->assertEquals($expectedResult, $result);
    }
}
