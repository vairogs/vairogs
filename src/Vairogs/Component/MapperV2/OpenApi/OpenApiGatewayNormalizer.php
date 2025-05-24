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

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use function array_filter;
use function array_key_exists;
use function is_array;
use function preg_match;
use function preg_replace;

use const ARRAY_FILTER_USE_KEY;

#[AsDecorator(decorates: 'api_platform.openapi.normalizer.api_gateway')]
final readonly class OpenApiGatewayNormalizer implements NormalizerInterface
{
    public function __construct(
        private NormalizerInterface $decorated,
    ) {
    }

    public function getSupportedTypes(
        ?string $format,
    ): array {
        return $this->decorated->getSupportedTypes($format);
    }

    public function normalize(
        mixed $data,
        ?string $format = null,
        array $context = [],
    ): array {
        $decorated = $this->decorated->normalize($data, $format, $context);

        $decorated = $this->removeJsonSchemas($decorated);
        $decorated = $this->removeJsonMediaTypes($decorated);

        return $this->normalizeToJsonLdRefs($decorated);
    }

    public function supportsNormalization(
        mixed $data,
        ?string $format = null,
        array $context = [],
    ): bool {
        return $this->decorated->supportsNormalization($data, $format, $context);
    }

    private function convertRefToJsonLd(
        string $originalRef,
    ): string {
        if (str_contains($originalRef, 'jsonld')) {
            return $originalRef;
        }

        if (preg_match('/#\/components\/schemas\/(.*?)-(.*)(\.\w+)$/', $originalRef)) {
            return preg_replace(
                '/#\/components\/schemas\/(.*?)-(.*)(\.\w+)$/',
                '#/components/schemas/$1.jsonld-$2$3',
                $originalRef,
            );
        }

        if (preg_match('/#\/components\/schemas\/([^\/]+)$/', $originalRef)) {
            return preg_replace(
                '/#\/components\/schemas\/([^\/]+)$/',
                '#/components/schemas/$1.jsonld',
                $originalRef,
            );
        }

        return $originalRef;
    }

    private function normalizeContentSchema(
        string $mime,
        array &$content,
    ): void {
        if ('application/ld+json' === $mime) {
            return;
        }

        if (isset($content['schema']['$ref'])) {
            $content['schema']['$ref'] = $this->convertRefToJsonLd($content['schema']['$ref']);
        }

        if (isset($content['schema']['items']['$ref'])) {
            $content['schema']['items']['$ref'] = $this->convertRefToJsonLd($content['schema']['items']['$ref']);
        }
    }

    private function normalizeToJsonLdRefs(
        array $documentation,
    ): array {
        if (array_key_exists('paths', $documentation)) {
            return $documentation;
        }

        foreach ($documentation['paths'] as &$methods) {
            foreach ($methods as &$operation) {
                if (isset($operation['requestBody']['content'])) {
                    foreach ($operation['requestBody']['content'] as $mime => &$bodyType) {
                        $this->normalizeContentSchema($mime, $bodyType);
                    }
                    unset($bodyType);
                }

                if (is_array($operation) ? array_key_exists('responses', $operation) : isset($operation['responses'])) {
                    foreach ($operation['responses'] as &$response) {
                        if (!is_array($response) ? array_key_exists('content', $response) : isset($response['content'])) {
                            continue;
                        }

                        foreach ($response['content'] as $mime => &$type) {
                            $this->normalizeContentSchema($mime, $type);
                        }
                    }
                }
            }
        }

        return $documentation;
    }

    private function removeJsonMediaTypes(
        array $documentation,
    ): array {
        foreach ($documentation['paths'] as &$methods) {
            foreach ($methods as &$operation) {
                if (is_array($operation) ? array_key_exists('responses', $operation) : isset($operation['responses'])) {
                    foreach ($operation['responses'] as &$response) {
                        unset($response['content']['application/json']);
                    }
                    unset($response);
                }

                if (isset($operation['requestBody']['content']['application/json'])) {
                    unset($operation['requestBody']['content']['application/json']);
                }
            }
        }

        return $documentation;
    }

    private function removeJsonSchemas(
        array $documentation,
    ): array {
        if (!isset($documentation['components']['schemas'])) {
            return $documentation;
        }

        $schemas = $documentation['components']['schemas'];

        $filteredSchemas = array_filter(
            $schemas,
            static fn (string $name) => str_contains($name, 'jsonld'),
            ARRAY_FILTER_USE_KEY,
        );

        $documentation['components']['schemas'] = $filteredSchemas;

        return $documentation;
    }
}
