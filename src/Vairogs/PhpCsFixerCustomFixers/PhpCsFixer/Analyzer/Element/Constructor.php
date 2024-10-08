<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\PhpCsFixerCustomFixers\PhpCsFixer\Analyzer\Element;

use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Tokens;

use function array_flip;
use function array_key_exists;
use function assert;
use function is_int;

use const T_CALLABLE;
use const T_ELLIPSIS;
use const T_STRING;
use const T_VARIABLE;

/**
 * @internal
 */
final readonly class Constructor
{
    public function __construct(
        private Tokens $tokens,
        private int $constructorIndex,
    ) {
    }

    public function getConstructorIndex(): int
    {
        return $this->constructorIndex;
    }

    public function getConstructorParameterNames(): array
    {
        $openParenthesis = $this->tokens->getNextTokenOfKind($this->constructorIndex, ['(']);
        assert(is_int($openParenthesis));
        $closeParenthesis = $this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $openParenthesis);

        $constructorParameterNames = [];

        for ($index = $openParenthesis + 1; $index < $closeParenthesis; $index++) {
            if (!$this->tokens[$index]->isGivenKind(T_VARIABLE)) {
                continue;
            }

            $constructorParameterNames[] = $this->tokens[$index]->getContent();
        }

        return $constructorParameterNames;
    }

    public function getConstructorPromotableAssignments(): array
    {
        $openParenthesis = $this->tokens->getNextTokenOfKind($this->constructorIndex, ['(']);
        assert(is_int($openParenthesis));
        $closeParenthesis = $this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $openParenthesis);

        $openBrace = $this->tokens->getNextTokenOfKind($closeParenthesis, ['{']);
        assert(is_int($openBrace));
        $closeBrace = $this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_CURLY_BRACE, $openBrace);

        $variables = [];
        $properties = [];
        $propertyToVariableMap = [];

        for ($index = $openBrace + 1; $index < $closeBrace; $index++) {
            if (!$this->tokens[$index]->isGivenKind(T_VARIABLE)) {
                continue;
            }

            $semicolonIndex = $this->tokens->getNextMeaningfulToken($index);
            assert(is_int($semicolonIndex));

            if (!$this->tokens[$semicolonIndex]->equals(';')) {
                continue;
            }

            $propertyIndex = $this->getPropertyIndex($index, $openBrace);

            if (null === $propertyIndex) {
                continue;
            }

            $properties[$propertyIndex] = $this->tokens[$propertyIndex]->getContent();
            $variables[$index] = $this->tokens[$index]->getContent();
            $propertyToVariableMap[$propertyIndex] = $index;
        }

        foreach ($this->getDuplicatesIndices($properties) as $duplicate) {
            unset($variables[$propertyToVariableMap[$duplicate]]);
        }

        foreach ($this->getDuplicatesIndices($variables) as $duplicate) {
            unset($variables[$duplicate]);
        }

        return array_flip($variables);
    }

    public function getConstructorPromotableParameters(): array
    {
        $openParenthesis = $this->tokens->getNextTokenOfKind($this->constructorIndex, ['(']);
        assert(is_int($openParenthesis));
        $closeParenthesis = $this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $openParenthesis);

        $constructorPromotableParameters = [];

        for ($index = $openParenthesis + 1; $index < $closeParenthesis; $index++) {
            if (!$this->tokens[$index]->isGivenKind(T_VARIABLE)) {
                continue;
            }

            $typeIndex = $this->tokens->getPrevMeaningfulToken($index);
            assert(is_int($typeIndex));

            if ($this->tokens[$typeIndex]->equalsAny(['(', ',', [T_CALLABLE], [T_ELLIPSIS]])) {
                continue;
            }

            $visibilityIndex = $this->tokens->getPrevTokenOfKind(
                $index,
                [
                    '(',
                    ',',
                    [CT::T_CONSTRUCTOR_PROPERTY_PROMOTION_PRIVATE],
                    [CT::T_CONSTRUCTOR_PROPERTY_PROMOTION_PROTECTED],
                    [CT::T_CONSTRUCTOR_PROPERTY_PROMOTION_PUBLIC],
                ],
            );
            assert(is_int($visibilityIndex));

            if (!$this->tokens[$visibilityIndex]->equalsAny(['(', ','])) {
                continue;
            }

            $constructorPromotableParameters[$index] = $this->tokens[$index]->getContent();
        }

        return $constructorPromotableParameters;
    }

    private function getDuplicatesIndices(
        array $array,
    ): array {
        $duplicates = [];
        $values = [];

        foreach ($array as $key => $value) {
            if (array_key_exists($value, $values)) {
                $duplicates[$values[$value]] = $values[$value];
                $duplicates[$key] = $key;
            }
            $values[$value] = $key;
        }

        return $duplicates;
    }

    private function getPropertyIndex(
        int $index,
        int $openBrace,
    ): ?int {
        $assignmentIndex = $this->tokens->getPrevMeaningfulToken($index);
        assert(is_int($assignmentIndex));

        if (!$this->tokens[$assignmentIndex]->equals('=')) {
            return null;
        }

        $propertyIndex = $this->tokens->getPrevMeaningfulToken($assignmentIndex);

        if (!$this->tokens[$propertyIndex]->isGivenKind(T_STRING)) {
            return null;
        }
        assert(is_int($propertyIndex));

        $objectOperatorIndex = $this->tokens->getPrevMeaningfulToken($propertyIndex);
        assert(is_int($objectOperatorIndex));

        $thisIndex = $this->tokens->getPrevMeaningfulToken($objectOperatorIndex);
        assert(is_int($thisIndex));

        if (!$this->tokens[$thisIndex]->equals([T_VARIABLE, '$this'])) {
            return null;
        }

        $prevThisIndex = $this->tokens->getPrevMeaningfulToken($thisIndex);
        assert(is_int($prevThisIndex));

        if ($prevThisIndex > $openBrace && !$this->tokens[$prevThisIndex]->equalsAny(['}', ';'])) {
            return null;
        }

        return $propertyIndex;
    }
}
