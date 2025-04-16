<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Tests\Functions\Preg;

use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Vairogs\Assets\DataProvider\Functions\Preg\PregDataProvider;
use Vairogs\Functions\Preg\Traits\_Match;
use Vairogs\Functions\Preg\Traits\_MatchAll;
use Vairogs\Functions\Preg\Traits\_Replace;
use Vairogs\Functions\Preg\Traits\_ReplaceCallback;
use Vairogs\Functions\Preg\Traits\_Split;

class PregTest extends TestCase
{
    #[DataProviderExternal(PregDataProvider::class, 'provideMatchMethod')]
    public function testMatch(
        string|array $pattern,
        string $subject,
        ?array &$matches,
        int $flags,
        int $offset,
        ?bool $expectedResult = null,
        ?array $expectedMatches = null,
        ?string $expectedException = null,
    ): void {
        if (null !== $expectedException) {
            $this->expectException($expectedException);
        }

        $result = new class {
            use _Match;
        }->match($pattern, $subject, $matches, $flags, $offset);

        if (null === $expectedException) {
            $this->assertEquals($expectedResult, $result);

            if (null !== $expectedMatches) {
                $this->assertEquals($expectedMatches, $matches);
            }
        }
    }

    #[DataProviderExternal(PregDataProvider::class, 'provideMatchAllMethod')]
    public function testMatchAll(
        string|array $pattern,
        string $subject,
        ?array &$matches,
        int $flags,
        int $offset,
        int|false|null $expectedResult = null,
        ?array $expectedMatches = null,
        ?string $expectedException = null,
    ): void {
        if (null !== $expectedException) {
            $this->expectException($expectedException);
        }

        $result = new class {
            use _MatchAll;
        }->matchAll($pattern, $subject, $matches, $flags, $offset);

        if (null === $expectedException) {
            $this->assertEquals($expectedResult, $result);

            if (null !== $expectedMatches) {
                $this->assertEquals($expectedMatches, $matches);
            }
        }
    }

    #[DataProviderExternal(PregDataProvider::class, 'provideReplaceMethod')]
    public function testReplace(
        string|array $pattern,
        string|array $replacement,
        string|array $subject,
        int $limit,
        ?int &$count,
        string|array|null $expectedResult = null,
        ?int $expectedCount = null,
        ?string $expectedException = null,
    ): void {
        if (null !== $expectedException) {
            $this->expectException($expectedException);
        }

        $result = new class {
            use _Replace;
        }->replace($pattern, $replacement, $subject, $limit, $count);

        if (null === $expectedException) {
            $this->assertEquals($expectedResult, $result);

            if (null !== $expectedCount) {
                $this->assertEquals($expectedCount, $count);
            }
        }
    }

    #[DataProviderExternal(PregDataProvider::class, 'provideReplaceCallbackMethod')]
    public function testReplaceCallback(
        string|array $pattern,
        callable $callback,
        string|array $subject,
        int $limit,
        ?int &$count,
        string|array|null $expectedResult = null,
        ?int $expectedCount = null,
        ?string $expectedException = null,
    ): void {
        if (null !== $expectedException) {
            $this->expectException($expectedException);
        }

        $result = new class {
            use _ReplaceCallback;
        }->replaceCallback($pattern, $callback, $subject, $limit, $count);

        if (null === $expectedException) {
            $this->assertEquals($expectedResult, $result);

            if (null !== $expectedCount) {
                $this->assertEquals($expectedCount, $count);
            }
        }
    }

    #[DataProviderExternal(PregDataProvider::class, 'provideSplitMethod')]
    public function testSplit(
        string $pattern,
        string $subject,
        int $limit,
        int $flags,
        ?array $expectedResult = null,
        ?string $expectedException = null,
    ): void {
        if (null !== $expectedException) {
            $this->expectException($expectedException);
        }

        $result = new class {
            use _Split;
        }->split($pattern, $subject, $limit, $flags);

        if (null === $expectedException) {
            $this->assertEquals($expectedResult, $result);
        }
    }
}
