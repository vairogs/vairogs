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

trait _IsHttps
{
    public function isHttps(
        Request $request,
    ): bool {
        return (new class {
            use _CheckHttps;
        })->checkHttps(request: $request) || (new class {
            use _CheckServerPort;
        })->checkServerPort(request: $request) || (new class {
            use _CheckHttpXForwardedSsl;
        })->checkHttpXForwardedSsl(request: $request) || (new class {
            use _CheckHttpXForwardedProto;
        })->checkHttpXForwardedProto(request: $request);
    }
}
