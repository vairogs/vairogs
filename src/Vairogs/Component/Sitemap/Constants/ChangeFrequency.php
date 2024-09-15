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

enum ChangeFrequency: string
{
    case ALWAYS = 'always';
    case DAILY = 'daily';
    case EMPTY = '';
    case HOURLY = 'hourly';
    case MONTHLY = 'monthly';
    case NEVER = 'never';
    case WEEKLY = 'weekly';
    case YEARLY = 'yearly';

    public function frequency(): ?string
    {
        return match ($this) {
            self::EMPTY => null,
            default => $this->value,
        };
    }
}
