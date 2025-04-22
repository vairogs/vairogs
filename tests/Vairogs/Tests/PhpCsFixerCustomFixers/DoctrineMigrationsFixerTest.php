<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Tests\PhpCsFixerCustomFixers;

use PhpCsFixer\Tokenizer\Tokens;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use Vairogs\Assets\PhpCsFixerCustomFixers\Fixer\DataProvider\DoctrineMigrationsFixerDataProvider;
use Vairogs\PhpCsFixerCustomFixers\Fixer\DoctrineMigrationsFixer;

final class DoctrineMigrationsFixerTest extends TestCase
{
    #[DataProviderExternal(DoctrineMigrationsFixerDataProvider::class, 'provideFixCases')]
    public function testFix(
        string $expected,
        ?string $input = null,
    ): void {
        $fixer = new DoctrineMigrationsFixer();
        $file = new SplFileInfo('some/file.php');
        $tokens = Tokens::fromCode($input ?? $expected);

        $fixer->fix($file, $tokens);

        $tokens->clearEmptyTokens();
        $tokens->generateCode();

        $this->assertSame($expected, $tokens->generateCode());

        $tokens = Tokens::fromCode($tokens->generateCode());
        $fixer->fix($file, $tokens);
        $tokens->clearEmptyTokens();
        $this->assertSame($expected, $tokens->generateCode());
    }
}
