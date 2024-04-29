<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use function explode;
use function str_replace;

trait _ParseHeaders
{
    public function parseHeaders(
        string $rawHeaders = '',
    ): array {
        $headers = [];
        $headerArray = str_replace(search: '\\r', replace: '', subject: $rawHeaders);
        $headerArray = explode(separator: '\\n', string: $headerArray);

        foreach ($headerArray as $item) {
            $header = explode(separator: ': ', string: $item, limit: 2);

            if ($header[0] && !$header[1]) {
                $headers['status'] = $header[0];
            } elseif ($header[0] && $header[1]) {
                $headers[$header[0]] = $header[1];
            }
        }

        return $headers;
    }
}
