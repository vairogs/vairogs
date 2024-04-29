<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use Symfony\Component\Intl\Countries;

use function mb_strtoupper;

trait _CountryName
{
    public function countryName(
        string $country,
        string $locale = 'en',
    ): string {
        return Countries::getName(country: mb_strtoupper(string: $country), displayLocale: $locale);
    }
}
