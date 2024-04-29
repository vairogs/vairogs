<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use function http_build_query;
use function parse_url;

trait _UrlEncode
{
    public function urlEncode(
        string $url,
    ): string {
        $urlParsed = parse_url(url: $url);

        $port = (string) ($urlParsed['port'] ?? '');
        $query = $urlParsed['query'] ?? '';

        if ('' !== $query) {
            /** @var string $query */
            $query = '?' . http_build_query(data: (new class() {
                use _BuildHttpQueryString;
            })->arrayFromQueryString(query: $query));
        }

        if ($port && ':' !== $port[0]) {
            $port = ':' . $port;
        }

        return $urlParsed['scheme'] . '://' . $urlParsed['host'] . $port . ($urlParsed['path'] ?? '') . $query;
    }
}
