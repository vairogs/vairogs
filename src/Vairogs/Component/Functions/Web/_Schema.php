<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use Symfony\Component\HttpFoundation\Request;
use Vairogs\Component\Functions\Web;

trait _Schema
{
    public function schema(
        Request $request,
    ): string {
        return (new class {
            use _IsHttps;
        })->isHttps(request: $request) ? Web::SCHEMA_HTTPS : Web::SCHEMA_HTTP;
    }
}
