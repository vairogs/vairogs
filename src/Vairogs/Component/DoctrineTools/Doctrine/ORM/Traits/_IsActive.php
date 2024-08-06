<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\ORM\Traits;

use Doctrine\ORM\Mapping as ORM;

trait _IsActive
{
    #[ORM\Column(options: ['default' => false])]
    private bool $isActive = false;

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(
        bool $isActive,
    ): static {
        $this->isActive = $isActive;

        return $this;
    }
}
