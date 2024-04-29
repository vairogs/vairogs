<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\ORM\Query\AST;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

abstract class BaseFunction extends FunctionNode
{
    protected string $functionPrototype;

    protected array $nodesMapping = [];

    protected array $nodes = [];

    /**
     * @throws QueryException
     */
    public function parse(
        Parser $parser,
    ): void {
        $this->customFunction();

        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->feedParserWithNodes($parser);
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(
        SqlWalker $sqlWalker,
    ): string {
        $dispatched = [];
        foreach ($this->nodes as $node) {
            $dispatched[] = null === $node ? 'null' : $node->dispatch($sqlWalker);
        }

        return vsprintf($this->functionPrototype, $dispatched);
    }

    abstract protected function customFunction(): void;

    protected function setFunctionPrototype(
        string $functionPrototype,
    ): void {
        $this->functionPrototype = $functionPrototype;
    }

    protected function addNodeMapping(
        string $parserMethod,
    ): void {
        $this->nodesMapping[] = $parserMethod;
    }

    /**
     * @throws QueryException
     */
    protected function feedParserWithNodes(
        Parser $parser,
    ): void {
        $nodesMappingCount = count($this->nodesMapping);
        $lastNode = $nodesMappingCount - 1;
        for ($i = 0; $i < $nodesMappingCount; $i++) {
            $this->nodes[$i] = $parser->{$this->nodesMapping[$i]}();
            if ($i < $lastNode) {
                $parser->match(TokenType::T_COMMA);
            }
        }
    }
}
