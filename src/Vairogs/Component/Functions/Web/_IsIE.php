<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use Symfony\Component\HttpFoundation\Request;
use Vairogs\Component\Functions\Text;

trait _IsIE
{
    public function isIE(
        Request $request,
    ): bool {
        return (new class {
            use Text\_ContainsAny;
        })->containsAny(haystack: $request->server->get(key: 'HTTP_USER_AGENT'), needles: ['MSIE', 'Edge', 'Trident/7']);
    }
}
