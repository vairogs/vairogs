<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\DoctrineTools\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Finder\Finder;
use Vairogs\Bundle\DependencyInjection\AbstractDependencyConfiguration;
use Vairogs\Bundle\VairogsBundle;
use Vairogs\Component\DoctrineTools\Doctrine\DBAL;
use Vairogs\Functions\Preg;
use Vairogs\Functions\Text;

use function array_keys;
use function class_exists;
use function file_get_contents;
use function strtoupper;
use function ucfirst;

final class DoctrineToolsConfiguration extends AbstractDependencyConfiguration
{
    public function registerPreConfiguration(
        ContainerConfigurator $container,
        ContainerBuilder $builder,
        string $component,
    ): void {
        if ($builder->hasExtension('doctrine')) {
            if ($builder->hasExtension('doctrine_migrations')) {
                $container->extension('doctrine_migrations', [
                    'migrations_paths' => [
                        'Vairogs\\Component\\DoctrineTools\\Migrations' => __DIR__ . '/../Resources/migrations',
                    ],
                ]);
            }

            $container->extension('doctrine', [
                'dbal' => [
                    'types' => [
                        'date' => DBAL\Type\UTCDateType::class,
                        'date_immutable' => DBAL\Type\UTCDateImmutableType::class,
                        'datetime' => DBAL\Type\UTCDateTimeType::class,
                        'datetime_immutable' => DBAL\Type\UTCDateTimeImmutableType::class,
                    ],
                ],
            ]);

            $managers = array_keys(VairogsBundle::getConfig('doctrine', $builder)['orm']['entity_managers'] ?? []);

            if ([] === $managers) {
                $managers = ['default'];
            }

            $types = ['string', 'datetime', 'numeric'];
            $functions = [];

            static $_helper = null;

            if (null === $_helper) {
                $_helper = new class {
                    use Preg\Traits\_Match;
                    use Text\Traits\_SnakeCaseFromCamelCase;
                };
            }

            foreach ($types as $type) {
                $finder = new Finder();
                $finder->files()->in(__DIR__ . '/../Doctrine/ORM/Query/AST/' . ucfirst($type))->name('*.php');
                $functions[$type] = [];

                foreach ($finder as $file) {
                    $fileContents = file_get_contents($file->getRealPath());

                    if ($_helper->match('/namespace\s+(.+?);/', $fileContents, $namespaceMatches)
                        && $_helper->match('/class\s+(\w+)/', $fileContents, $classMatches)) {
                        $className = $classMatches[1];
                        $fullClassName = $namespaceMatches[1] . '\\' . $className;

                        if (class_exists($fullClassName)) {
                            $functions[$type][strtoupper($_helper->snakeCaseFromCamelCase($className))] = $fullClassName;
                        }
                    }
                }
            }

            foreach ($managers as $manager) {
                $container->extension('doctrine', [
                    'orm' => [
                        'entity_managers' => [
                            $manager => [
                                'dql' => [
                                    'string_functions' => $functions['string'],
                                    'datetime_functions' => $functions['datetime'],
                                    'numeric_functions' => $functions['numeric'],
                                ],
                            ],
                        ],
                    ],
                ]);
            }
        }
    }

    public function usesDoctrine(): bool
    {
        return true;
    }
}
