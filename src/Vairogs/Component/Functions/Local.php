<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions;

final class Local
{
    use Local\_Exists;
    use Local\_FileExistsCwd;
    use Local\_GetEnv;
    use Local\_HumanFIleSize;
    use Local\_IsInstalled;
    use Local\_MkDir;
    use Local\_RmDir;
    use Local\_WillBeAvailable;
}
