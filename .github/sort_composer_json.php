#!/usr/bin/env php
<?php

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Parse command line arguments
$searchPath = __DIR__;
$searchFilename = 'composer.json';

if (array_key_exists(1, $argv) && !empty($argv[1])) {
    $searchPath = $argv[1];
}

if (array_key_exists(2, $argv) && !empty($argv[2])) {
    $searchFilename = $argv[2];
}

// Find all matching files in the specified directory
$jsonFiles = [];
$directory = new RecursiveDirectoryIterator($searchPath);
$iterator = new RecursiveIteratorIterator($directory);

foreach ($iterator as $file) {
    if ($file->getFilename() === $searchFilename) {
        $jsonFiles[] = $file->getPathname();
    }
}

$processedFiles = 0;
$failedFiles = 0;

foreach ($jsonFiles as $file) {
    try {
        // Read the composer.json file
        $content = file_get_contents($file);
        $json = json_decode($content, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new Exception('Error decoding JSON: ' . json_last_error_msg());
        }

        // Determine the file type and apply appropriate sorting
        $filename = basename($file);

        if ('composer.json' === $filename) {
            // First sort all keys according to Composer schema
            $json = sortComposerKeys($json);

            // Then process composer.json sections
            if (array_key_exists('require', $json)) {
                $json['require'] = sortDependencies($json['require']);
            }

            if (array_key_exists('require-dev', $json)) {
                $json['require-dev'] = sortDependencies($json['require-dev']);
            }

            if (array_key_exists('suggest', $json)) {
                $json['suggest'] = sortDependencies($json['suggest']);
            }

            if (array_key_exists('conflict', $json)) {
                $json['conflict'] = sortDependencies($json['conflict']);
            }
        } else {
            // Sort components.json by path
            usort($json, fn ($a, $b) => strcmp($a['path'], $b['path']));
        }

        // Write the updated composer.json file
        $updatedContent = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $updatedContent = str_replace('    ', '    ', $updatedContent); // Ensure 4 spaces indentation
        // Ensure exactly one newline at the end of the file
        $updatedContent = rtrim($updatedContent) . "\n";
        file_put_contents($file, $updatedContent);

        $processedFiles++;
    } catch (Exception $e) {
        echo "Error processing file {$file}: {$e->getMessage()}\n";
        $failedFiles++;
    }
}

echo "Processed {$processedFiles} {$searchFilename} files successfully.\n";

if ($failedFiles > 0) {
    echo "Failed to process {$failedFiles} files.\n";
}

/**
 * Sort dependencies in the following order:
 * 1. PHP
 * 2. Extensions
 * 3. Libraries
 *
 * Within each category, dependencies are sorted alphabetically.
 */
function sortDependencies(
    array $dependencies,
): array {
    $php = [];
    $extensions = [];
    $libraries = [];

    foreach ($dependencies as $package => $version) {
        if ('php' === $package) {
            $php[$package] = $version;
        } elseif (str_starts_with($package, 'ext-')) {
            $extensions[$package] = $version;
        } else {
            $libraries[$package] = $version;
        }
    }

    // Sort extensions and libraries alphabetically
    ksort($extensions);
    ksort($libraries);

    // Combine the sorted dependencies
    return array_merge($php, $extensions, $libraries);
}

/**
 * Sort composer.json keys according to the order defined in the Composer schema.
 * https://getcomposer.org/schema.json.
 */
function sortComposerKeys(
    array $json,
): array {
    try {
        $schemaFile = __DIR__ . '/composer-schema.json';

        // Check if schema file exists locally
        if (is_file($schemaFile)) {
            $schemaContent = file_get_contents($schemaFile);

            if (false === $schemaContent) {
                throw new Exception('Failed to read local schema file');
            }
        } else {
            // Fetch the Composer schema from getcomposer.org
            $schemaContent = @file_get_contents('https://getcomposer.org/schema.json');

            if (false === $schemaContent) {
                throw new Exception('Failed to fetch Composer schema');
            }

            // Save schema locally for future use
            file_put_contents($schemaFile, $schemaContent);
        }

        $schema = json_decode($schemaContent, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new Exception('Error decoding Composer schema: ' . json_last_error_msg());
        }

        // Extract the order of keys from the schema properties
        $order = array_keys($schema['properties'] ?? []);

        if (empty($order)) {
            throw new Exception('Failed to extract keys from Composer schema');
        }
    } catch (Exception $e) {
        echo "Warning: {$e->getMessage()}. Using hardcoded key order.\n";

        // Fallback to hardcoded order if schema cannot be fetched or parsed
        $order = [
            'name',
            'description',
            'license',
            'type',
            'abandoned',
            'version',
            'default-branch',
            'non-feature-branches',
            'keywords',
            'readme',
            'time',
            'authors',
            'homepage',
            'support',
            'funding',
            'source',
            'dist',
            '_comment',
            'require',
            'require-dev',
            'replace',
            'conflict',
            'provide',
            'suggest',
            'repositories',
            'minimum-stability',
            'prefer-stable',
            'autoload',
            'autoload-dev',
            'target-dir',
            'include-path',
            'bin',
            'archive',
            'php-ext',
            'config',
            'extra',
            'scripts',
            'scripts-descriptions',
            'scripts-aliases',
        ];
    }

    // Create a new array with keys in the correct order
    $sorted = [];

    foreach ($order as $key) {
        if (array_key_exists($key, $json)) {
            $sorted[$key] = $json[$key];
        }
    }

    // Add any keys that are not in the predefined order at the end
    foreach ($json as $key => $value) {
        if (!array_key_exists($key, $sorted)) {
            $sorted[$key] = $value;
        }
    }

    return $sorted;
}
