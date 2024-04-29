<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use Symfony\Component\HttpFoundation\Request;
use Vairogs\Component\Functions\Web;

trait _CheckHttpXForwardedSsl
{
    public function checkHttpXForwardedSsl(
        Request $request,
    ): bool {
        return $request->server->has(key: Web::HEADER_SSL) && 'on' === $request->server->get(key: Web::HEADER_SSL);
    }
}
