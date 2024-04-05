<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\ORM\Traits;

trait Entity
{
    use _Id;
    use CreatedUpdated;
    use IsActive;
    use Version;
}
