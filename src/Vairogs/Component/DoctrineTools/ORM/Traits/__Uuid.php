<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\ORM\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid;

trait __Uuid
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uid\Uuid $id = null;

    public function getId(): ?Uid\Uuid
    {
        return $this->id;
    }
}
