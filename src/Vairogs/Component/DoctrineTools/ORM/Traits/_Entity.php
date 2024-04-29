<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\ORM\Traits;

trait _Entity
{
    use __Id;
    use _CreatedUpdated;
    use _IsActive;
    use _Version;
}
