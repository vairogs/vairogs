<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\String;

use Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\BaseFunction;

class Ilike extends BaseFunction
{
    protected function customFunction(): void
    {
        $this->setFunctionPrototype('%s ILIKE %s');
        $this->addNodeMapping('StringPrimary');
        $this->addNodeMapping('StringPrimary');
    }
}
