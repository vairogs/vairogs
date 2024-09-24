<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Web;

use Vairogs\Component\Functions\Iteration;
use Vairogs\Component\Functions\Iteration\_JsonDecode;
use Vairogs\Component\Functions\Local\_CurlUA;

use function sprintf;

trait _LatestReleaseTag
{
    public function latestReleaseTag(
        string $repository,
    ): string {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _CurlUA;
                use _JsonDecode;
            };
        }

        $options = [
            'http' => [
                'header' => sprintf("User-Agent: %s\r\n", $_helper->getCurlUserAgent()),
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents(sprintf('https://api.github.com/repos/%s/releases/latest', $repository), false, $context);

        return $_helper->jsonDecode((string) $response, Iteration::ASSOCIATIVE)['tag_name'];
    }
}
