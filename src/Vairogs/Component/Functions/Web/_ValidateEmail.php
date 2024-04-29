<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use function filter_var;

use const FILTER_UNSAFE_RAW;
use const FILTER_VALIDATE_EMAIL;

trait _ValidateEmail
{
    public function validateEmail(
        string $email,
    ): bool {
        return false !== filter_var(value: filter_var(value: $email, filter: FILTER_UNSAFE_RAW), filter: FILTER_VALIDATE_EMAIL);
    }
}
