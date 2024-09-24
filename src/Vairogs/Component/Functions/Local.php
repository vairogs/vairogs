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

final class Local
{
    use Local\_CurlUA;
    use Local\_Exists;
    use Local\_FileExistsCwd;
    use Local\_GetClassFromFile;
    use Local\_GetEnv;
    use Local\_HumanFIleSize;
    use Local\_IsInstalled;
    use Local\_MkDir;
    use Local\_RmDir;
    use Local\_WillBeAvailable;
}
