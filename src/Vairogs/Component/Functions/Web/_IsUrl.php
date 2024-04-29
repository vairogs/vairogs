<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use function filter_var;

use const FILTER_SANITIZE_URL;
use const FILTER_VALIDATE_URL;

trait _IsUrl
{
    public function isUrl(
        string $url,
    ): bool {
        /* @noinspection BypassedUrlValidationInspection */
        return false !== filter_var(value: filter_var(value: $url, filter: FILTER_SANITIZE_URL), filter: FILTER_VALIDATE_URL);
    }
}
