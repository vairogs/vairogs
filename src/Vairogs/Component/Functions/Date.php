<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions;

final class Date
{
    use Date\_Date;
    use Date\_DateNullable;
    use Date\_DateWithoutFormat;
    use Date\_ExcelDate;
    use Date\_FormatDate;
    use Date\_FromUnixTimestamp;
    use Date\_TimeFormat;
    use Date\_ValidateDate;
    use Date\_ValidateDateBasic;

    public const string FORMAT = 'd-m-Y H:i:s';
    public const string FORMAT_TS = 'D M d Y H:i:s T';

    public const array EXTRA_FORMATS = [
        self::FORMAT,
        self::FORMAT_TS,
    ];

    public const int JAN = 31;
    public const int FEB = 28;
    public const int FEB_LONG = 29;
    public const int MAR = 31;
    public const int APR = 30;
    public const int MAY = 31;
    public const int JUN = 30;
    public const int JUL = 31;
    public const int AUG = 31;
    public const int SEP = 30;
    public const int OCT = 31;
    public const int NOV = 30;
    public const int DEC = 31;

    public const int HOUR = 60 * self::MIN;
    public const int MIN = 60 * self::SEC;
    public const int MS = 1;
    public const int SEC = 1000 * self::MS;

    public const array TIME = [
        'hour' => self::HOUR,
        'minute' => self::MIN,
        'second' => self::SEC,
        'micro' => self::MS,
    ];
}
