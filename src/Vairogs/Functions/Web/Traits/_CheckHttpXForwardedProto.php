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

trait _CheckHttpXForwardedProto
{
    public function checkHttpXForwardedProto(
        Request $request,
    ): bool {
        return $request->server->has(key: Functions::HEADER_PROTO) && 'https' === $request->server->get(key: Functions::HEADER_PROTO);
    }
}
