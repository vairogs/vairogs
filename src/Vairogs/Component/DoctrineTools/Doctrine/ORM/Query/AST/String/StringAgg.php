<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\String;

use Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\BaseFunction;

class StringAgg extends BaseFunction
{
    protected function customFunction(): void
    {
        $this->setFunctionPrototype('STRING_AGG(%s, %s)');
        $this->addNodeMapping('StringPrimary');
        $this->addNodeMapping('StringPrimary');
    }
}
