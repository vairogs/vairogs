<?php declare(strict_types = 1);

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

        return (string) (new class() {
            use Iteration\_FirstMatchAsString;
        })->firstMatchAsString(keys: $headers, haystack: $request->server->all());
    }
}
