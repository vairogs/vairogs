<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Settings\Constants\Enum;

use Vairogs\Component\Functions\Iteration\_Cases;

enum Storage: string
{
    use _Cases;
    case FILE = 'file';
    case MEMORY = 'memory';

    case ORM = 'orm';
}
