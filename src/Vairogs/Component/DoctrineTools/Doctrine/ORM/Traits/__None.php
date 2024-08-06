<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\ORM\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait __None
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: Types::STRING, unique: true)]
    protected ?string $id = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(
        ?string $id,
    ): static {
        $this->id = $id;

        return $this;
    }
}
