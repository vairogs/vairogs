<?php declare(strict_types = 1);

namespace Vairogs\Component\Settings\Constants\Enum;

use Vairogs\Component\Functions\Traits\Cases;

enum Storage: string
{
    use Cases;

    case JSON = 'json';
    case ORM = 'orm';
}
