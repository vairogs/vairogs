<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Web\Traits;

use Symfony\Component\HttpFoundation\HeaderBag;

trait _RawHeaders
{
    public function rawHeaders(
        HeaderBag $headerBag,
    ): string {
        $string = '';

        foreach ($headerBag->all() as $header => $value) {
            $string .= $header . ': ' . $value[0] . '\r\n';
        }

        return $string;
    }
}
