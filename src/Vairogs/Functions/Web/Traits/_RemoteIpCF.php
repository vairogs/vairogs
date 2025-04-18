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
use Vairogs\Functions\Web\Functions;

trait _RemoteIpCF
{
    public function remoteIpCF(
        Request $request,
        bool $trust = false,
    ): string {
        if ($request->server->has(key: Functions::HTTP_CF_CONNECTING_IP)) {
            return $request->server->get(key: Functions::HTTP_CF_CONNECTING_IP);
        }

        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _RemoteIp;
            };
        }

        return $_helper->remoteIp(request: $request, trust: $trust);
    }
}
