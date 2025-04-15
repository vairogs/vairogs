<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Web\Traits;

use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Vairogs\Functions\Text;

use function array_merge;
use function file_get_contents;

trait _RequestIdentity
{
    /**
     * @throws ReflectionException
     */
    public function requestIdentity(
        Request $request,
        string $ipUrl = 'https://api.ipify.org/',
    ): array {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _BuildArrayFromObject;
                use Text\Traits\_UniqueId;
            };
        }

        $additionalData = [
            'actualIp' => file_get_contents(filename: $ipUrl),
            'uuid' => $request->server->get(key: 'REQUEST_TIME', default: '') . $_helper->uniqueId(),
        ];

        return array_merge($_helper->buildArrayFromObject(object: $request), $additionalData);
    }
}
