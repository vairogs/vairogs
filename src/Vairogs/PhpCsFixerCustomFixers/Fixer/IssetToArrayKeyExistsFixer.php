<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\PhpCsFixerCustomFixers\Fixer;

use PhpCsFixer\Tokenizer\Analyzer\FunctionsAnalyzer;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Vairogs\PhpCsFixerCustomFixers\PhpCsFixer\AbstractFixer;

use function assert;
use function count;
use function is_int;

use const T_ISSET;
use const T_STRING;
use const T_WHITESPACE;

final class IssetToArrayKeyExistsFixer extends AbstractFixer
{
    public function applyFix(
        SplFileInfo $file,
        Tokens $tokens,
    ): void {
        for ($index = $tokens->count() - 1; $index > 0; $index--) {
            if (!$tokens[$index]->isGivenKind(T_ISSET)) {
                continue;
            }

            if (1 !== count(new FunctionsAnalyzer()->getFunctionArguments($tokens, $index))) {
                continue;
            }

            $openParenthesis = $tokens->getNextMeaningfulToken($index);
            assert(is_int($openParenthesis));

            $closeParenthesis = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $openParenthesis);

            $closeBrackets = $tokens->getPrevMeaningfulToken($closeParenthesis);
            assert(is_int($closeBrackets));

            if (!$tokens[$closeBrackets]->equals(']')) {
                continue;
            }

            $openBrackets = $tokens->findBlockStart(Tokens::BLOCK_TYPE_ARRAY_SQUARE_BRACE, $closeBrackets);

            $keyStartIndex = $tokens->getNextMeaningfulToken($openBrackets);
            assert(is_int($keyStartIndex));
            $keyEndIndex = $tokens->getPrevMeaningfulToken($closeBrackets);

            $keyTokens = [];

            for ($i = $keyStartIndex; $i <= $keyEndIndex; $i++) {
                if ($tokens[$i]->equals('')) {
                    continue;
                }
                $keyTokens[] = $tokens[$i];
            }
            $keyTokens[] = new Token(',');
            $keyTokens[] = new Token([T_WHITESPACE, ' ']);

            $tokens->clearRange($openBrackets, $closeBrackets);
            $tokens->insertAt($openParenthesis + 1, $keyTokens);
            $tokens[$index] = new Token([T_STRING, 'array_key_exists']);
        }
    }

    public function getDocumentation(): string
    {
        return 'Function `array_key_exists` must be used instead of `isset` when possible.';
    }

    public function getSampleCode(): string
    {
        return '<?php
            if (isset($array[$key])) {
                echo $array[$key];
            }
        ';
    }

    public function isCandidate(
        Tokens $tokens,
    ): bool {
        return $tokens->isTokenKindFound(T_ISSET);
    }

    public function isRisky(): bool
    {
        return true;
    }
}
