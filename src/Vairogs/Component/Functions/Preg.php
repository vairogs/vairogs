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

final class Preg
{
    use Preg\_AddUtf8Modifier;
    use Preg\_Match;
    use Preg\_MatchAll;
    use Preg\_NewPregException;
    use Preg\_RemoveUtf8Modifier;
    use Preg\_Replace;
    use Preg\_ReplaceCallback;
    use Preg\_Split;
}
