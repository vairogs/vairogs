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

final class Iteration
{
    use Iteration\_AddElementIfNotExists;
    use Iteration\_ArrayFlipRecursive;
    use Iteration\_ArrayIntersectKeyRecursive;
    use Iteration\_ArrayValuesFiltered;
    use Iteration\_FilterKeyEndsWith;
    use Iteration\_FilterKeyStartsWith;
    use Iteration\_FirstMatchAsString;
    use Iteration\_HaveCommonElements;
    use Iteration\_IsAssociative;
    use Iteration\_IsEmpty;
    use Iteration\_IsMultiDimentional;
    use Iteration\_JsonDecode;
    use Iteration\_JsonEncode;
    use Iteration\_MakeMultiDimensional;
    use Iteration\_MakeOneDimension;
    use Iteration\_Pick;
    use Iteration\_RecursiveKSort;
    use Iteration\_RemoveFromArray;
    use Iteration\_Unique;
    use Iteration\_UniqueMap;
    use Iteration\_Unpack;

    public const int FORCE_ARRAY = 0b0001;
    public const int PRETTY = 0b0010;
    public const int ASSOCIATIVE = 1;
    public const int OBJECT = 0;
}
