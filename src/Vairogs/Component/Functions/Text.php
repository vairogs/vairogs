<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions;

final class Text
{
    use Text\_Br2nl;
    use Text\_CamelCase;
    use Text\_CleanText;
    use Text\_Compare;
    use Text\_Contains;
    use Text\_ContainsAny;
    use Text\_CountryName;
    use Text\_CyrillicToLatin;
    use Text\_HtmlEntityDecode;
    use Text\_IsHex;
    use Text\_KeepNumeric;
    use Text\_LastPart;
    use Text\_LatinToCyrillic;
    use Text\_LimitChars;
    use Text\_LimitWords;
    use Text\_LongestSubstrLength;
    use Text\_Nl2br;
    use Text\_NormalizedValue;
    use Text\_OneSpace;
    use Text\_PascalCase;
    use Text\_Pluralize;
    use Text\_RandomString;
    use Text\_ReverseUTF8;
    use Text\_Sanitize;
    use Text\_SanitizeFloat;
    use Text\_ScalarToString;
    use Text\_Sha;
    use Text\_Shuffle;
    use Text\_Singularize;
    use Text\_SnakeCaseFromCamelCase;
    use Text\_SnakeCaseFromSentence;
    use Text\_StripSpace;
    use Text\_ToString;
    use Text\_TruncateSafe;
    use Text\_UniqueId;

    public const array MAP_CYRILLIC = [
        'е', 'ё', 'ж', 'х', 'ц', 'ч', 'ш', 'щ', 'ю', 'я',
        'Е', 'Ё', 'Ж', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ю', 'Я',
        'а', 'б', 'в', 'г', 'д', 'з', 'и', 'й', 'к', 'л',
        'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'ъ',
        'ы', 'ь', 'э', 'А', 'Б', 'В', 'Г', 'Д', 'З', 'И',
        'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т',
        'У', 'Ф', 'Ъ', 'Ы', 'Ь', 'Э',
    ];
    public const array MAP_LATIN = [
        'ye', 'ye', 'zh', 'kh', 'ts', 'ch', 'sh', 'shch', 'yu', 'ya',
        'Ye', 'Ye', 'Zh', 'Kh', 'Ts', 'Ch', 'Sh', 'Shch', 'Yu', 'Ya',
        'a', 'b', 'v', 'g', 'd', 'z', 'i', 'y', 'k', 'l',
        'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'ʺ',
        'y', '–', 'e', 'A', 'B', 'V', 'G', 'D', 'Z', 'I',
        'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T',
        'U', 'F', 'ʺ', 'Y', '–', 'E',
    ];

    public const string BASIC = self::EN_LOWERCASE . self::EN_UPPERCASE . self::DIGITS;
    public const string DIGITS = '0123456789';
    public const string EN_LOWERCASE = 'abcdefghijklmnopqrstuvwxyz';
    public const string EN_UPPERCASE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public const string EXTENDED = self::BASIC . self::SYMBOLS;
    public const string LV_LOWERCASE = 'aābcčdeēfgģhiījkķlļmnņoprsštuūvzž';
    public const string LV_UPPERCASE = 'AāBCČDEĒFGĢHIĪJKĶLĻMNŅOPRSŠTUŪVZŽ';
    public const string SYMBOLS = '!@#$%^&*()_-=+;:.,?';
    public const string UTF32LE = 'UTF-32LE';
    public const string UTF8 = 'UTF-8';
}
