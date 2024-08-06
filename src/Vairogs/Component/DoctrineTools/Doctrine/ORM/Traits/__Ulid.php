<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\ORM\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid;

trait __Ulid
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    private ?Uid\Ulid $id = null;

    public function getId(): ?Uid\Ulid
    {
        return $this->id;
    }
}
