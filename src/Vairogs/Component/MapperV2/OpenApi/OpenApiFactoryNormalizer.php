<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\MapperV2\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;

use function array_key_exists;
use function is_array;

final readonly class OpenApiFactoryNormalizer // implements OpenApiFactoryInterface
{
    public function __construct(
        private OpenApiFactoryInterface $decorated,
    ) {
    }

    public function __invoke(
        array $context = [],
    ): OpenApi {
        $openApi = ($this->decorated)($context);

        foreach ($openApi->getPaths()->getPaths() as $pathItem) {
            foreach ($pathItem->getOperations() as $operation) {
                $responses = $operation->getResponses();

                foreach ($responses as $response) {
                    $content = $response->getContent();

                    if (is_array($content) ? array_key_exists('application/json', $content) : isset($content['application/json'])) {
                        unset($content['application/json']);
                        $response = $response->withContent($content);
                        $responses->add($response);
                    }
                }
            }
        }

        return $openApi;
    }
}
