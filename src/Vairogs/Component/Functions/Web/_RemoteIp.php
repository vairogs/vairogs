<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Web;

use Symfony\Component\HttpFoundation\Request;
use Vairogs\Component\Functions\Iteration;
use Vairogs\Component\Functions\Web;

trait _RemoteIp
{
    public function remoteIp(
        Request $request,
        bool $trust = false,
    ): string {
        $headers = [Web::REMOTE_ADDR, ];

        if ($trust) {
            $headers = [Web::HTTP_CLIENT_IP, Web::HTTP_X_REAL_IP, Web::HTTP_X_FORWARDED_FOR, Web::REMOTE_ADDR, ];
        }

        return (string) (new class {
            use Iteration\_FirstMatchAsString;
        })->firstMatchAsString(keys: $headers, haystack: $request->server->all());
    }
}
