<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\PhpCsFixerCustomFixers\PhpCsFixer\Analyzer;

use Exception;
use InvalidArgumentException;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\Tokenizer\TokensAnalyzer;
use Vairogs\Component\Functions\Preg\_Match;
use Vairogs\PhpCsFixerCustomFixers\PhpCsFixer\Analyzer\Element\Argument;
use Vairogs\PhpCsFixerCustomFixers\PhpCsFixer\Analyzer\Element\ArrayElement;
use Vairogs\PhpCsFixerCustomFixers\PhpCsFixer\Analyzer\Element\CaseElement;
use Vairogs\PhpCsFixerCustomFixers\PhpCsFixer\Analyzer\Element\Constructor;
use Vairogs\PhpCsFixerCustomFixers\PhpCsFixer\Analyzer\Element\SwitchElement;

use function array_keys;
use function assert;
use function call_user_func_array;
use function count;
use function current;
use function end;
use function explode;
use function in_array;
use function is_array;
use function is_int;
use function ksort;
use function mb_strlen;
use function mb_strpos;
use function mb_strtolower;
use function reset;
use function sprintf;

use const T_ARRAY;
use const T_ATTRIBUTE;
use const T_CASE;
use const T_CLASS;
use const T_CONST;
use const T_DEFAULT;
use const T_DOUBLE_ARROW;
use const T_ENDSWITCH;
use const T_FUNCTION;
use const T_ISSET;
use const T_PRIVATE;
use const T_PROTECTED;
use const T_STATIC;
use const T_STRING;
use const T_SWITCH;
use const T_VARIABLE;

/**
 * @internal
 */
final class Analyzer
{
    public const int TYPINT_OPTIONAL = 10022;
    public const int TYPINT_DOUBLE_DOTS = 10025;

    private TokensAnalyzer $analyzer;

    public function __construct(
        private readonly Tokens $tokens,
    ) {
        $this->analyzer = new TokensAnalyzer($tokens);
    }

    public function __call(
        string $name,
        array $arguments,
    ): mixed {
        return call_user_func_array([$this->analyzer, $name], $arguments);
    }

    /**
     * @throws Exception
     */
    public function endOfTheStatement(
        ?int $index,
    ): ?int {
        return $this->findBlockEndMatchingOpeningToken($index, '}', '{');
    }

    public function findAllSequences(
        array $seqs,
        mixed $start = null,
        mixed $end = null,
    ): array {
        $sequences = [];

        foreach ($seqs as $seq) {
            $index = $start ?? 0;

            do {
                $extract = $this->tokens->findSequence($seq, (int) $index, $end);

                if (null !== $extract) {
                    $keys = array_keys($extract);
                    $index = end($keys) + 1;
                    $sequences[reset($keys)] = $extract;
                }
            } while (null !== $extract);
        }

        ksort($sequences);

        return $sequences;
    }

    public function findNonAbstractConstructor(
        int $classIndex,
    ): ?Constructor {
        if (!$this->tokens[$classIndex]->isGivenKind(T_CLASS)) {
            throw new InvalidArgumentException(sprintf('Index %d is not a class.', $classIndex));
        }

        foreach ($this->analyzer->getClassyElements() as $index => $element) {
            if ($element['classIndex'] !== $classIndex) {
                continue;
            }

            if (!$this->isConstructor($index, $element)) {
                continue;
            }

            $constructorAttributes = $this->analyzer->getMethodAttributes($index);

            if ($constructorAttributes['abstract']) {
                return null;
            }

            return new Constructor($this->tokens, $index);
        }

        return null;
    }

    public function getArrayElements(
        int $index,
    ): array {
        $startIndex = null;
        $endIndex = null;

        if ($this->tokens[$index]->isGivenKind(CT::T_ARRAY_SQUARE_BRACE_OPEN)) {
            $startIndex = $this->tokens->getNextMeaningfulToken($index);
            $endIndex = $this->tokens->getPrevMeaningfulToken($this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_ARRAY_SQUARE_BRACE, $index));
        } elseif ($this->tokens[$index]->isGivenKind(T_ARRAY)) {
            $arrayOpenBraceIndex = $this->tokens->getNextTokenOfKind($index, ['(']);
            $startIndex = $this->tokens->getNextMeaningfulToken($arrayOpenBraceIndex);
            $endIndex = $this->tokens->getPrevMeaningfulToken($this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $arrayOpenBraceIndex));
        }

        if (!is_int($startIndex) || !is_int($endIndex)) {
            throw new InvalidArgumentException(sprintf('Index %d is not an array.', $index));
        }

        return $this->getElementsForArrayContent($startIndex, $endIndex);
    }

    public function getBeginningOfTheLine(
        int $index,
    ): ?int {
        for ($i = $index; $i >= 0; $i--) {
            if (false !== mb_strpos($this->tokens[$i]->getContent(), "\n")) {
                return $i;
            }
        }

        return null;
    }

    /**
     * @throws Exception
     */
    public function getClosingAttribute(
        int $index,
    ): ?int {
        return $this->findBlockEndMatchingOpeningToken($index, CT::T_ATTRIBUTE_CLOSE, T_ATTRIBUTE);
    }

    /**
     * @throws Exception
     */
    public function getClosingBracket(
        int $index,
    ): ?int {
        return $this->findBlockEndMatchingOpeningToken($index, ']', '[');
    }

    /**
     * @throws Exception
     */
    public function getClosingCurlyBracket(
        int $index,
    ): ?int {
        return $this->findBlockEndMatchingOpeningToken($index, '}', '{');
    }

    /**
     * @throws Exception
     */
    public function getClosingParenthesis(
        int $index,
    ): ?int {
        return $this->findBlockEndMatchingOpeningToken($index, ')', '(');
    }

    public function getElements(
        ?int $startIndex = null,
    ): array {
        if (null === $startIndex) {
            foreach ($this->tokens as $index => $token) {
                if (!$token->isClassy()) {
                    continue;
                }

                $index = $this->tokens->getNextTokenOfKind($index, ['{']);

                break;
            }
            $startIndex = $index ?? $startIndex;
        }

        $startIndex++;
        $elements = [];

        while (true) {
            $element = [
                'start' => $startIndex,
                'visibility' => 'public',
                'static' => false,
            ];

            for ($i = $startIndex;; $i++) {
                $token = $this->tokens[$i];

                if ('}' === $token->getContent()) {
                    return $elements;
                }

                if ($token->isGivenKind(T_STATIC)) {
                    $element['static'] = true;

                    continue;
                }

                if ($token->isGivenKind([T_PROTECTED, T_PRIVATE])) {
                    $element['visibility'] = mb_strtolower($token->getContent());

                    continue;
                }

                if (!$token->isGivenKind([CT::T_USE_TRAIT, T_CONST, T_VARIABLE, T_FUNCTION])) {
                    continue;
                }

                $type = $this->detectElementType($i);
                $element['type'] = $type;

                switch ($type) {
                    case 'method':
                        $element['methodName'] = $this->tokens[$this->tokens->getNextMeaningfulToken($i)]->getContent();

                        break;

                    case 'property':
                        $element['propertyName'] = $token->getContent();

                        break;
                }
                $element['end'] = $this->findElementEnd($i);

                break;
            }

            $elements[] = $element;
            $startIndex = $element['end'] + 1;
        }
    }

    public function getEndOfTheLine(
        int $index,
    ): ?int {
        for ($i = $index; $i < $this->tokens->count(); $i++) {
            if (false !== mb_strpos($this->tokens[$i]->getContent(), "\n")) {
                return $i;
            }
        }

        return null;
    }

    public function getFunctionArguments(
        ?int $index,
    ): array {
        $argumentsRange = $this->getArgumentsRange($index);

        if (null === $argumentsRange) {
            return [];
        }

        [$argumentStartIndex, $argumentsEndIndex] = $argumentsRange;

        $arguments = [];
        $index = $currentArgumentStart = $argumentStartIndex;

        while ($index < $argumentsEndIndex) {
            $blockType = Tokens::detectBlockType($this->tokens[$index]);

            if (null !== $blockType && $blockType['isStart']) {
                $index = $this->tokens->findBlockEnd($blockType['type'], $index);

                continue;
            }

            $index = $this->tokens->getNextMeaningfulToken($index);
            assert(is_int($index));

            if (!$this->tokens[$index]->equals(',')) {
                continue;
            }

            $currentArgumentEnd = $this->tokens->getPrevMeaningfulToken($index);
            assert(is_int($currentArgumentEnd));

            $arguments[] = $this->createArgumentAnalysis($currentArgumentStart, $currentArgumentEnd);

            $currentArgumentStart = $this->tokens->getNextMeaningfulToken($index);
            assert(is_int($currentArgumentStart));
        }

        $arguments[] = $this->createArgumentAnalysis($currentArgumentStart, $argumentsEndIndex);

        return $arguments;
    }

    public function getLineIndentation(
        int $index,
    ): string {
        $start = $this->getBeginningOfTheLine($index);
        $token = $this->tokens[$start];
        $parts = explode("\n", $token->getContent());

        return end($parts);
    }

    /**
     * @throws Exception
     */
    public function getMethodArguments(
        int $index,
    ): array {
        $methodName = $this->tokens->getNextMeaningfulToken($index);
        $openParenthesis = $this->tokens->getNextMeaningfulToken($methodName);
        $closeParenthesis = $this->getClosingParenthesis($openParenthesis);

        $arguments = [];

        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _Match;
            };
        }

        for ($position = $openParenthesis + 1; $position < $closeParenthesis; $position++) {
            $token = $this->tokens[$position];

            if ($token->isWhitespace()) {
                continue;
            }

            $argumentType = null;
            $argumentName = $position;
            $argumentAsDefault = false;
            $argumentNullable = false;

            if (!$_helper->match('/^\$.+/', $this->tokens[$argumentName]->getContent())) {
                do {
                    if (!$this->tokens[$argumentName]->isWhitespace()) {
                        $argumentType .= $this->tokens[$argumentName]->getContent();
                    }

                    $argumentName++;
                } while (!$_helper->match('/^\$.+/', $this->tokens[$argumentName]->getContent()));
            }

            $next = $this->tokens->getNextMeaningfulToken($argumentName);

            if ('=' === $this->tokens[$next]->getContent()) {
                $argumentAsDefault = true;
                $value = $this->tokens->getNextMeaningfulToken($next);
                $argumentNullable = 'null' === $this->tokens[$value]->getContent();
            }

            $arguments[$position] = [
                'type' => $argumentType,
                'name' => $this->tokens[$argumentName]->getContent(),
                'nullable' => $argumentNullable,
                'asDefault' => $argumentAsDefault,
            ];

            $nextComma = $this->getNextComma($position);

            if (null === $nextComma) {
                return $arguments;
            }

            $position = $nextComma;
        }

        return $arguments;
    }

    /**
     * @throws Exception
     */
    public function getNextComma(
        ?int $index,
    ): ?int {
        return $this->findBlockEndMatchingOpeningToken($index, ',', ['(', '[', '{']);
    }

    /**
     * @throws Exception
     */
    public function getNextSemiColon(
        ?int $index,
    ): ?int {
        return $this->findBlockEndMatchingOpeningToken($index, ';', ['(', '[', '{']);
    }

    /**
     * @throws Exception
     */
    public function getNumberOfArguments(
        int $index,
    ): int {
        return count($this->getMethodArguments($index));
    }

    /**
     * @throws Exception
     */
    public function getReturnedType(
        int $index,
    ): array|string|null {
        if (!$this->tokens[$index]->isGivenKind(T_FUNCTION)) {
            throw new Exception(sprintf('Expected token: T_FUNCTION Token %d id contains %s.', $index, $this->tokens[$index]->getContent()));
        }

        $methodName = $this->tokens->getNextMeaningfulToken($index);
        $openParenthesis = $this->tokens->getNextMeaningfulToken($methodName);
        $closeParenthesis = $this->getClosingParenthesis($openParenthesis);

        $next = $this->tokens->getNextMeaningfulToken($closeParenthesis);

        if (null === $next) {
            return null;
        }

        if (!$this->tokens[$next]->isGivenKind(self::TYPINT_DOUBLE_DOTS)) {
            return null;
        }

        $next = $this->tokens->getNextMeaningfulToken($next);

        if (null === $next) {
            return null;
        }

        $optionnal = $this->tokens[$next]->isGivenKind(self::TYPINT_OPTIONAL);

        $next = $optionnal
            ? $this->tokens->getNextMeaningfulToken($next)
            : $next;

        do {
            $return = $this->tokens[$next]->getContent();
            $next++;

            if ($this->tokens[$next]->isWhitespace() || ';' === $this->tokens[$next]->getContent()) {
                return $optionnal
                    ? [$return, null]
                    : $return;
            }
        } while (!in_array($this->tokens[$index]->getContent(), ['{', ';'], true));

        return null;
    }

    public function getSizeOfTheLine(
        int $index,
    ): int {
        $start = $this->getBeginningOfTheLine($index);
        $end = $this->getEndOfTheLine($index);
        $size = 0;

        $parts = explode("\n", $this->tokens[$start]->getContent());
        $size += mb_strlen(end($parts));

        $parts = explode("\n", $this->tokens[$end]->getContent());
        $size += mb_strlen(current($parts));

        for ($i = $start + 1; $i < $end; $i++) {
            $size += mb_strlen($this->tokens[$i]->getContent());
        }

        return $size;
    }

    public function getSwitchAnalysis(
        int $switchIndex,
    ): SwitchElement {
        if (!$this->tokens[$switchIndex]->isGivenKind(T_SWITCH)) {
            throw new InvalidArgumentException(sprintf('Index %d is not "switch".', $switchIndex));
        }

        $casesStartIndex = $this->getCasesStart($switchIndex);
        $casesEndIndex = $this->getCasesEnd($casesStartIndex);

        $cases = [];
        $index = $casesStartIndex;

        while ($index < $casesEndIndex) {
            $index = $this->getNextSameLevelToken($index);

            if (!$this->tokens[$index]->isGivenKind([T_CASE, T_DEFAULT])) {
                continue;
            }

            $cases[] = $this->getCaseAnalysis($index);
        }

        return new SwitchElement($casesStartIndex, $casesEndIndex, $cases);
    }

    /**
     * @throws Exception
     */
    public function isInsideSwitchCase(
        int $index,
    ): bool {
        $switches = $this->findAllSequences([[[T_SWITCH]]]);
        $intervals = [];

        foreach ($switches as $i => $switch) {
            $start = $this->tokens->getNextTokenOfKind($i, ['{']);
            $end = $this->getClosingCurlyBracket($start);

            $intervals[] = [$start, $end];
        }

        foreach ($intervals as $interval) {
            [$start, $end] = $interval;

            if ($index >= $start && $index <= $end) {
                return true;
            }
        }

        return false;
    }

    private function createArgumentAnalysis(
        int $startIndex,
        int $endIndex,
    ): Argument {
        $isConstant = true;

        for ($index = $startIndex; $index <= $endIndex; $index++) {
            if ($this->tokens[$index]->isGivenKind(T_VARIABLE)) {
                $isConstant = false;
            }

            if ($this->tokens[$index]->equals('(')) {
                $prevParenthesisIndex = $this->tokens->getPrevMeaningfulToken($index);
                assert(is_int($prevParenthesisIndex));

                if (!$this->tokens[$prevParenthesisIndex]->isGivenKind(T_ARRAY)) {
                    $isConstant = false;
                }
            }
        }

        return new Argument($startIndex, $endIndex, $isConstant);
    }

    private function createArrayElementAnalysis(
        int $startIndex,
        int $endIndex,
    ): ArrayElement {
        $index = $startIndex;

        while ($endIndex > $index = $this->nextCandidateIndex($index)) {
            if (!$this->tokens[$index]->isGivenKind(T_DOUBLE_ARROW)) {
                continue;
            }

            $keyEndIndex = $this->tokens->getPrevMeaningfulToken($index);
            assert(is_int($keyEndIndex));

            $valueStartIndex = $this->tokens->getNextMeaningfulToken($index);
            assert(is_int($valueStartIndex));

            return new ArrayElement($startIndex, $keyEndIndex, $valueStartIndex, $endIndex);
        }

        return new ArrayElement(null, null, $startIndex, $endIndex);
    }

    private function detectElementType(
        int $index,
    ): array|string {
        $token = $this->tokens[$index];

        if ($token->isGivenKind(CT::T_USE_TRAIT)) {
            return 'use_trait';
        }

        if ($token->isGivenKind(T_CONST)) {
            return 'constant';
        }

        if ($token->isGivenKind(T_VARIABLE)) {
            return 'property';
        }

        $nameToken = $this->tokens[$this->tokens->getNextMeaningfulToken($index)];

        if ($nameToken->equals([T_STRING, '__construct'], false)) {
            return 'construct';
        }

        if ($nameToken->equals([T_STRING, '__destruct'], false)) {
            return 'destruct';
        }

        if (
            $nameToken->equalsAny([
                [T_STRING, 'setUpBeforeClass'],
                [T_STRING, 'tearDownAfterClass'],
                [T_STRING, 'setUp'],
                [T_STRING, 'tearDown'],
            ], false)
        ) {
            return ['phpunit', mb_strtolower($nameToken->getContent())];
        }

        if (0 === mb_strpos($nameToken->getContent(), '__')) {
            return 'magic';
        }

        return 'method';
    }

    /**
     * @throws Exception
     */
    private function findBlockEndMatchingOpeningToken(
        ?int $index,
        string|int $closingToken,
        string|int|array $openingToken,
    ): ?int {
        do {
            $index = $this->tokens->getNextMeaningfulToken($index);

            if (null === $index) {
                return null;
            }

            if (is_array($openingToken)) {
                foreach ($openingToken as $opening) {
                    if ($opening === $this->tokens[$index]->getContent()) {
                        $index = $this->getClosingMatchingToken($index, $opening);

                        break;
                    }
                }
            } elseif ($openingToken === $this->tokens[$index]->getContent()) {
                $index = $this->getClosingMatchingToken($index, $openingToken);
            }
        } while ($closingToken !== $this->tokens[$index]->getContent());

        return $index;
    }

    private function findElementEnd(
        ?int $index,
    ): int {
        $index = $this->tokens->getNextTokenOfKind($index, ['{', ';']);

        if ('{' === $this->tokens[$index]->getContent()) {
            $index = $this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_CURLY_BRACE, $index);
        }

        $index++;

        while ($index < count($this->tokens) && ($this->tokens[$index]->isWhitespace(" \t") || $this->tokens[$index]->isComment())) {
            $index++;
        }

        return $this->tokens[$index - 1]->isWhitespace() ? $index - 2 : $index - 1;
    }

    private function getArgumentsRange(
        int $index,
    ): ?array {
        if (!$this->tokens[$index]->isGivenKind([T_ISSET, T_STRING])) {
            throw new InvalidArgumentException(sprintf('Index %d is not a function.', $index));
        }

        $openParenthesis = $this->tokens->getNextMeaningfulToken($index);
        assert(is_int($openParenthesis));

        if (!$this->tokens[$openParenthesis]->equals('(')) {
            throw new InvalidArgumentException(sprintf('Index %d is not a function.', $index));
        }

        $closeParenthesis = $this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $openParenthesis);

        $argumentsEndIndex = $this->tokens->getPrevMeaningfulToken($closeParenthesis);
        assert(is_int($argumentsEndIndex));

        if ($openParenthesis === $argumentsEndIndex) {
            return null;
        }

        if ($this->tokens[$argumentsEndIndex]->equals(',')) {
            $argumentsEndIndex = $this->tokens->getPrevMeaningfulToken($argumentsEndIndex);
            assert(is_int($argumentsEndIndex));
        }

        $argumentStartIndex = $this->tokens->getNextMeaningfulToken($openParenthesis);
        assert(is_int($argumentStartIndex));

        return [$argumentStartIndex, $argumentsEndIndex];
    }

    private function getCaseAnalysis(
        int $index,
    ): CaseElement {
        while ($index < $this->tokens->count()) {
            $index = $this->getNextSameLevelToken($index);

            if ($this->tokens[$index]->equalsAny([':', ';'])) {
                break;
            }
        }

        return new CaseElement($index);
    }

    private function getCasesEnd(
        int $casesStartIndex,
    ): int {
        if ($this->tokens[$casesStartIndex]->equals('{')) {
            return $this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_CURLY_BRACE, $casesStartIndex);
        }

        $index = $casesStartIndex;

        while ($index < $this->tokens->count()) {
            $index = $this->getNextSameLevelToken($index);

            if ($this->tokens[$index]->isGivenKind(T_ENDSWITCH)) {
                break;
            }
        }

        $afterEndswitchIndex = $this->tokens->getNextMeaningfulToken($index);
        assert(is_int($afterEndswitchIndex));

        return $this->tokens[$afterEndswitchIndex]->equals(';') ? $afterEndswitchIndex : $index;
    }

    private function getCasesStart(
        int $switchIndex,
    ): int {
        $parenthesisStartIndex = $this->tokens->getNextMeaningfulToken($switchIndex);
        assert(is_int($parenthesisStartIndex));
        $parenthesisEndIndex = $this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $parenthesisStartIndex);

        $casesStartIndex = $this->tokens->getNextMeaningfulToken($parenthesisEndIndex);
        assert(is_int($casesStartIndex));

        return $casesStartIndex;
    }

    /**
     * @throws Exception
     */
    private function getClosingMatchingToken(
        int $index,
        string $openingToken,
    ): ?int {
        return match ($openingToken) {
            '(' => $this->getClosingParenthesis($index),
            '[' => $this->getClosingBracket($index),
            '{' => $this->getClosingCurlyBracket($index),
            default => throw new Exception(sprintf('Unsupported opening token: %s', $openingToken)),
        };
    }

    private function getElementsForArrayContent(
        ?int $startIndex,
        int $endIndex,
    ): array {
        $elements = [];

        $index = $startIndex;

        while ($endIndex >= $index = $this->nextCandidateIndex($index)) {
            if (!$this->tokens[$index]->equals(',')) {
                continue;
            }

            $elementEndIndex = $this->tokens->getPrevMeaningfulToken($index);
            assert(is_int($elementEndIndex));

            $elements[] = $this->createArrayElementAnalysis($startIndex, $elementEndIndex);

            $startIndex = $this->tokens->getNextMeaningfulToken($index);
            assert(is_int($startIndex));
        }

        if ($startIndex <= $endIndex) {
            $elements[] = $this->createArrayElementAnalysis($startIndex, $endIndex);
        }

        return $elements;
    }

    private function getNextSameLevelToken(
        ?int $index,
    ): int {
        $index = $this->tokens->getNextMeaningfulToken($index);
        assert(is_int($index));

        if ($this->tokens[$index]->isGivenKind(T_SWITCH)) {
            return $this->getSwitchAnalysis($index)->getCasesEnd();
        }

        $blockType = Tokens::detectBlockType($this->tokens[$index]);

        if (null !== $blockType && $blockType['isStart']) {
            return $this->tokens->findBlockEnd($blockType['type'], $index) + 1;
        }

        return $index;
    }

    private function isConstructor(
        int $index,
        array $element,
    ): bool {
        if ('method' !== $element['type']) {
            return false;
        }

        $functionNameIndex = $this->tokens->getNextMeaningfulToken($index);
        assert(is_int($functionNameIndex));

        return $this->tokens[$functionNameIndex]->equals([T_STRING, '__construct'], false);
    }

    private function nextCandidateIndex(
        int $index,
    ): int {
        if ($this->tokens[$index]->equals('{')) {
            return $this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_CURLY_BRACE, $index) + 1;
        }

        if ($this->tokens[$index]->equals('(')) {
            return $this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $index) + 1;
        }

        if ($this->tokens[$index]->isGivenKind(CT::T_ARRAY_SQUARE_BRACE_OPEN)) {
            return $this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_ARRAY_SQUARE_BRACE, $index) + 1;
        }

        if ($this->tokens[$index]->isGivenKind(T_ARRAY)) {
            $arrayOpenBraceIndex = $this->tokens->getNextTokenOfKind($index, ['(']);
            assert(is_int($arrayOpenBraceIndex));

            return $this->tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $arrayOpenBraceIndex) + 1;
        }

        return $index + 1;
    }
}
