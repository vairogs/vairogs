<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\MapperV2\DependencyInjection;

use Vairogs\Bundle\DependencyInjection\AbstractDependencyConfiguration;

final class MapperV2Configuration extends AbstractDependencyConfiguration
{
    public function usesDoctrine(): bool
    {
        return true;
    }
}
