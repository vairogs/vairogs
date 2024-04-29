<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\ORM\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait __Id
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: Types::INTEGER, unique: true)]
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
