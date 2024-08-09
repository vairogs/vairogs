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
use Vairogs\Component\Functions\Web;

trait _RemoteIpCF
{
    public function remoteIpCF(
        Request $request,
        bool $trust = false,
    ): string {
        if ($request->server->has(key: Web::HTTP_CF_CONNECTING_IP)) {
            return $request->server->get(key: Web::HTTP_CF_CONNECTING_IP);
        }

        return (new class {
            use _RemoteIp;
        })->remoteIp(request: $request, trust: $trust);
    }
}
