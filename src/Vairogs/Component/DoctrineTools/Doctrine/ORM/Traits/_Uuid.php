<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\ORM\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid;

#[ORM\HasLifecycleCallbacks]
trait _Uuid
{
    #[ORM\Column(type: UuidType::NAME, unique: true, options: ['default' => 'gen_random_uuid()'])]
    private ?Uid\Uuid $uuid = null;

    public function getUuid(): ?Uid\Uuid
    {
        return $this->uuid;
    }

    public function setUuid(
        ?Uid\Uuid $uuid,
    ): static {
        $this->uuid = $uuid;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        if (null === $this->uuid) {
            $this->uuid = Uid\Uuid::v4();
        }
    }
}
