<?php declare(strict_types = 1);

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

        return (new class() {
            use _RemoteIp;
        })->remoteIp(request: $request, trust: $trust);
    }
}
