<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\String;

use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;
use Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\BaseFunction;

use function array_pop;
use function count;
use function vsprintf;

class RegexpReplace extends BaseFunction
{
    public function getSql(
        SqlWalker $sqlWalker,
    ): string {
        $dispatched = [];

        foreach ($this->nodes as $node) {
            $dispatched[] = $node->dispatch($sqlWalker);
        }

        $flagsPart = 4 === count($this->nodes) ? ', ' . array_pop($dispatched) : '';

        return vsprintf($this->functionPrototype, $dispatched) . $flagsPart;
    }

    protected function customFunction(): void
    {
        $this->setFunctionPrototype('REGEXP_REPLACE(%s, %s, %s%s)');

        $this->addNodeMapping('StringPrimary');
        $this->addNodeMapping('StringPrimary');
        $this->addNodeMapping('StringPrimary');
    }

    protected function feedParserWithNodes(
        Parser $parser,
    ): void {
        parent::feedParserWithNodes($parser);

        if ($parser->getLexer()->isNextToken(TokenType::T_COMMA)) {
            $parser->match(TokenType::T_COMMA);
            $this->nodes[] = $parser->StringPrimary();
        }
    }
}
