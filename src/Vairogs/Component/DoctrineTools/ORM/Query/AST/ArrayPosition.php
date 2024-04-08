<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\ORM\Query\AST;

class ArrayPosition extends BaseFunction
{
    protected function customFunction(): void
    {
        $this->setFunctionPrototype('ARRAY_POSITION(ARRAY[%s]::int[], %s)');
        $this->addNodeMapping('StringPrimary');
        $this->addNodeMapping('StringPrimary');
    }
}
