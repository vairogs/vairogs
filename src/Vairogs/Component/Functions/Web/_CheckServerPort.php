<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use Symfony\Component\HttpFoundation\Request;
use Vairogs\Component\Functions\Web;

trait _CheckServerPort
{
    public function checkServerPort(
        Request $request,
    ): bool {
        return $request->server->has(key: Web::HEADER_PORT) && Web::HTTPS === (int) $request->server->get(key: Web::HEADER_PORT);
    }
}
