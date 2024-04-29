<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use Symfony\Component\HttpFoundation\Request;
use Vairogs\Component\Functions\Web;

trait _CheckHttpXForwardedProto
{
    public function checkHttpXForwardedProto(
        Request $request,
    ): bool {
        return $request->server->has(key: Web::HEADER_PROTO) && 'https' === $request->server->get(key: Web::HEADER_PROTO);
    }
}
