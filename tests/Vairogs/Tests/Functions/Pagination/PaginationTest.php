<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Tests\Functions\Pagination;

use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Vairogs\Assets\Functions\Pagination\DataProvider\PaginationDataProvider;
use Vairogs\Functions\Pagination\Pagination;

class PaginationTest extends TestCase
{
    #[DataProviderExternal(PaginationDataProvider::class, 'providePaginateMethod')]
    public function testPaginate(
        int $visible,
        int $total,
        int $current,
        int $indicator,
        ?array $expectedResult,
        ?string $expectedException,
    ): void {
        $pagination = new Pagination();

        if (null !== $expectedException) {
            $this->expectException($expectedException);
        }

        $result = $pagination->paginate($visible, $total, $current, $indicator);

        if (null === $expectedException) {
            $this->assertSame($expectedResult, $result);
        }
    }
}
