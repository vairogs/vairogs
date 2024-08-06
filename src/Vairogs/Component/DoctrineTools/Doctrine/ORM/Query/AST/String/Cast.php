<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\String;

use Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\BaseFunction;

class Cast extends BaseFunction
{
    protected function customFunction(): void
    {
        $this->setFunctionPrototype('CAST(REPLACE(%s, \',\', \'.\') AS %s)');
        $this->addNodeMapping('StringPrimary');
        $this->addNodeMapping('StringPrimary');
    }
}
