<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use Symfony\Component\HttpFoundation\Request;
use Vairogs\Component\Functions\Web;

trait _CheckHttps
{
    public function checkHttps(
        Request $request,
    ): bool {
        return $request->server->has(key: Web::HEADER_HTTPS) && 'on' === $request->server->get(key: Web::HEADER_HTTPS);
    }
}
