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

use Symfony\Component\HttpFoundation\Request;
use Vairogs\Functions\Iteration;
use Vairogs\Functions\Web\Functions;

trait _RemoteIp
{
    public function remoteIp(
        Request $request,
        bool $trust = false,
    ): string {
        $headers = [Functions::REMOTE_ADDR, ];

        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use Iteration\Traits\_FirstMatchAsString;
            };
        }

        if ($trust) {
            $headers = [Functions::HTTP_CLIENT_IP, Functions::HTTP_X_REAL_IP, Functions::HTTP_X_FORWARDED_FOR, Functions::REMOTE_ADDR, ];
        }

        return (string) $_helper->firstMatchAsString(keys: $headers, haystack: $request->server->all());
    }
}
