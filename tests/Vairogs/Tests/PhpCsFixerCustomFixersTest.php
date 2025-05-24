<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Tests;

use PhpCsFixer\Tokenizer\Tokens;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use Vairogs\Assets\DataProvider\PhpCsFixerCustomFixersDataProvider;
use Vairogs\PhpCsFixerCustomFixers\Fixer\IssetToArrayKeyExistsFixer;

class PhpCsFixerCustomFixersTest extends TestCase
{
    #[DataProviderExternal(PhpCsFixerCustomFixersDataProvider::class, 'provideIssetToArrayKeyExistsFixerCases')]
    public function testIssetToArrayKeyExistsFixer(
        string $expected,
        ?string $input = null,
    ): void {
        $fixer = new IssetToArrayKeyExistsFixer();
        $this->doTest($expected, $input, $fixer);
    }

    private function doTest(
        string $expected,
        ?string $input,
        IssetToArrayKeyExistsFixer $fixer,
    ): void {
        if (null === $input) {
            $input = $expected;
        }

        if ($input === $expected) {
            $this->addToAssertionCount(1);

            return;
        }

        $file = new SplFileInfo(__FILE__);
        $tokens = Tokens::fromCode($input);

        $fixer->fix($file, $tokens);

        $tokens->clearEmptyTokens();
        $this->assertSame($expected, $tokens->generateCode());

        $tokens = Tokens::fromCode($tokens->generateCode());
        $fixer->fix($file, $tokens);
        $tokens->clearEmptyTokens();
        $this->assertSame($expected, $tokens->generateCode());
    }
}
