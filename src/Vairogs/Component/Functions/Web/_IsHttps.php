<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use Symfony\Component\HttpFoundation\Request;

trait _IsHttps
{
    public function isHttps(
        Request $request,
    ): bool {
        return (new class() {
            use _CheckHttps;
        })->checkHttps(request: $request) || (new class() {
            use _CheckServerPort;
        })->checkServerPort(request: $request) || (new class() {
            use _CheckHttpXForwardedSsl;
        })->checkHttpXForwardedSsl(request: $request) || (new class() {
            use _CheckHttpXForwardedProto;
        })->checkHttpXForwardedProto(request: $request);
    }
}
