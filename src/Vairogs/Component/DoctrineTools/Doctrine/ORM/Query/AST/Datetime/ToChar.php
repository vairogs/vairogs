<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\Datetime;

use Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\BaseFunction;

class ToChar extends BaseFunction
{
    protected function customFunction(): void
    {
        $this->setFunctionPrototype('TO_CHAR(%s, %s)');
        $this->addNodeMapping('ArithmeticExpression');
        $this->addNodeMapping('StringPrimary');
    }
}
