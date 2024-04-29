<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use Symfony\Component\HttpFoundation\HeaderBag;

trait _RawHeaders
{
    public function rawHeaders(
        HeaderBag $headerBag,
    ): string {
        $string = '';

        foreach ($headerBag->all() as $header => $value) {
            $string .= $header . ': ' . $value[0] . '\r\n';
        }

        return $string;
    }
}
