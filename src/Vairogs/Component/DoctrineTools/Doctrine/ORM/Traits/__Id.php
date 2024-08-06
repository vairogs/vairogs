<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\ORM\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait __Id
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: Types::BIGINT, unique: true)]
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
