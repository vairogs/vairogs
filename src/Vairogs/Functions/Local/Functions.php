<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Local;

final class Functions
{
    use Traits\_CurlUA;
    use Traits\_Exists;
    use Traits\_FileExistsCwd;
    use Traits\_GetEnv;
    use Traits\_HumanFIleSize;
    use Traits\_IsInstalled;
    use Traits\_MkDir;
    use Traits\_RmDir;
    use Traits\_WillBeAvailable;
}
