<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Constants;

final class Symbol
{
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
