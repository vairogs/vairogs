<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\ORM\Query\AST;

class ToChar extends BaseFunction
{
    protected function customFunction(): void
    {
        $this->setFunctionPrototype('TO_CHAR(%s, %s)');
        $this->addNodeMapping('ArithmeticExpression');
        $this->addNodeMapping('StringPrimary');
    }
}
