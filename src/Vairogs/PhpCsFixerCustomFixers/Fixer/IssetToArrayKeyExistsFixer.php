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

use PhpCsFixer\Tokenizer\Analyzer\ArgumentsAnalyzer;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Vairogs\PhpCsFixerCustomFixers\PhpCsFixer\AbstractFixer;

use function array_key_first;
use function assert;
use function count;
use function is_int;
use function strtolower;

use const T_ISSET;
use const T_STRING;
use const T_WHITESPACE;

final class IssetToArrayKeyExistsFixer extends AbstractFixer
{
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

    protected function applyFix(
        SplFileInfo $file,
        Tokens $tokens,
    ): void {
        $argumentsAnalyzer = new ArgumentsAnalyzer();

        for ($index = $tokens->count() - 1; $index > 0; $index--) {
            if (!$tokens[$index]->isGivenKind(T_ISSET)) {
                continue;
            }

            $openParenthesis = $tokens->getNextMeaningfulToken($index);
            assert(is_int($openParenthesis));
            $closeParenthesis = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $openParenthesis);

            $argumentCount = $argumentsAnalyzer->countArguments($tokens, $openParenthesis, $closeParenthesis);

            if (1 !== $argumentCount) {
                continue;
            }

            $arguments = $argumentsAnalyzer->getArguments($tokens, $openParenthesis, $closeParenthesis);
            $argumentStart = array_key_first($arguments);

            $closeBrackets = $tokens->getPrevMeaningfulToken($closeParenthesis);
            assert(is_int($closeBrackets));

            if (!$tokens[$closeBrackets]->equals(']')) {
                continue;
            }

            $openBrackets = $tokens->findBlockStart(Tokens::BLOCK_TYPE_ARRAY_SQUARE_BRACE, $closeBrackets);
            $arrayVar = $tokens->generatePartialCode($argumentStart, $openBrackets - 1);

            // Skip if it's not a simple variable (e.g. object property or method call)
            if (str_contains($arrayVar, '->') || str_contains($arrayVar, '::') || str_contains($arrayVar, '(')) {
                continue;
            }

            // Skip if already transformed
            $prevToken = $tokens->getPrevMeaningfulToken($index);

            if (null !== $prevToken && $tokens[$prevToken]->equals(':')) {
                continue;
            }

            // Skip if it's an array object (variable name contains 'arrayobject')
            if (str_contains(strtolower($arrayVar), 'arrayobject')) {
                continue;
            }

            // Skip if it's a nested array access (contains '[')
            if (str_contains($arrayVar, '[')) {
                continue;
            }

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

            $tokens->clearRange($index, $closeParenthesis);

            // Add is_array check and array_key_exists
            $tokens[$index] = new Token([T_STRING, 'is_array']);
            $tokens->insertAt($index + 1, [
                new Token('('),
                new Token([T_STRING, $arrayVar]),
                new Token(')'),
                new Token([T_WHITESPACE, ' ']),
                new Token('?'),
                new Token([T_WHITESPACE, ' ']),
                new Token([T_STRING, 'array_key_exists']),
                new Token('('),
            ]);

            $tokens->insertAt($index + 9, $keyTokens);
            $tokens->insertAt($index + 9 + count($keyTokens), [
                new Token(','),
                new Token([T_WHITESPACE, ' ']),
                new Token([T_STRING, $arrayVar]),
                new Token(')'),
                new Token([T_WHITESPACE, ' ']),
                new Token(':'),
                new Token([T_WHITESPACE, ' ']),
                new Token([T_STRING, 'isset']),
                new Token('('),
                new Token([T_STRING, $arrayVar]),
                new Token('['),
            ]);

            foreach ($keyTokens as $token) {
                $tokens->insertAt($index + 20 + count($keyTokens), $token);
            }

            $tokens->insertAt($index + 20 + count($keyTokens) * 2, [
                new Token(']'),
                new Token(')'),
            ]);
        }
    }
}
