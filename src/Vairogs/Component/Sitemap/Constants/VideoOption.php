<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Sitemap\Constants;

use Vairogs\Component\Functions\Iteration\_ArrayValuesFiltered;
use Vairogs\Component\Functions\Iteration\_Cases;

enum VideoOption: string
{
    use _Cases;

    case OPTION_NO = 'no';
    case OPTION_YES = 'yes';

    case PLATFORM_MOBILE = 'mobile';
    case PLATFORM_TV = 'tv';
    case PLATFORM_WEB = 'web';

    case RESTRICTION_ALLOW = 'allow';
    case RESTRICTION_DENY = 'deny';

    public function getOptions(): array
    {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _ArrayValuesFiltered;
            };
        }

        return $_helper->arrayValuesFiltered(input: self::getCases(), with: 'OPTION_');
    }

    public function getPlatforms(): array
    {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _ArrayValuesFiltered;
            };
        }

        return $_helper->arrayValuesFiltered(input: self::getCases(), with: 'PLATFORM_');
    }

    public function getRestrictions(): array
    {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _ArrayValuesFiltered;
            };
        }

        return $_helper->arrayValuesFiltered(input: self::getCases(), with: 'RESTRICTION_');
    }
}
