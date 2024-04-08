<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\ORM\Query\AST;

class Cast extends BaseFunction
{
    protected function customFunction(): void
    {
        $this->setFunctionPrototype('CAST(REPLACE(%s, \',\', \'.\') AS decimal)');
        $this->addNodeMapping('StringPrimary');
    }
}
