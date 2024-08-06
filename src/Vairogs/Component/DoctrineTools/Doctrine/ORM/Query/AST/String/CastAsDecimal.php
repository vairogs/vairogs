<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\String;

use Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\BaseFunction;

class CastAsDecimal extends BaseFunction
{
    protected function customFunction(): void
    {
        $this->setFunctionPrototype('CAST(REPLACE(%s, \',\', \'.\') AS decimal)');
        $this->addNodeMapping('StringPrimary');
    }
}
