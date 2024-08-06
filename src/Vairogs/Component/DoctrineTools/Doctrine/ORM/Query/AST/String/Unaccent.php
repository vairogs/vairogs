<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\String;

use Vairogs\Component\DoctrineTools\Doctrine\ORM\Query\AST\BaseFunction;

class Unaccent extends BaseFunction
{
    protected function customFunction(): void
    {
        $this->setFunctionPrototype('UNACCENT(%s)');
        $this->addNodeMapping('StringPrimary');
    }
}
