<?php declare(strict_types = 1);

namespace Vairogs\Component\Settings\DependencyInjection;

use InvalidArgumentException;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Vairogs\Bundle\DependencyInjection\Dependency;
use Vairogs\Component\Settings\Constants\Enum\Storage;

use function class_exists;
use function dirname;

final readonly class SettingsConfiguration implements Dependency
{
    public function addSection(ArrayNodeDefinition $rootNode, callable $enableIfStandalone): void
    {
        $rootNode
            ->children()
                ->arrayNode('settings')
                    ->{$enableIfStandalone('vairogs/settings', self::class)}()
                    ->children()
                        ->enumNode('storage')->values(Storage::getCases())->defaultValue(Storage::JSON->value)->end()
                        ->arrayNode(Storage::JSON->value)
                            ->canBeEnabled()
                            ->children()
                                ->scalarNode('directory')->defaultValue('%kernel.project_dir%/var/vairogs/')->end()
                                ->scalarNode('filename')->defaultValue('settings.json')->end()
                            ->end()
                        ->end()
                        ->arrayNode(Storage::ORM->value)
                            ->canBeEnabled()
                            ->children()
                                ->scalarNode('entity_class')->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->validate()
                ->ifTrue(fn ($v) => Storage::JSON->value === $v['settings']['storage'])
                ->then(function ($v) {
                    $v['settings'][Storage::JSON->value]['enabled'] = true;
                    $v['settings'][Storage::ORM->value]['enabled'] = false;

                    return $v;
                })
            ->end()
            ->validate()
                ->ifTrue(fn ($v) => Storage::ORM->value === $v['settings']['storage'])
                ->then(function ($v) {
                    $v['settings'][Storage::ORM->value]['enabled'] = true;
                    $v['settings'][Storage::JSON->value]['enabled'] = false;

                    return $v;
                })
            ->end()
            ->validate()
                ->ifTrue(fn ($v) => $v['settings'][Storage::ORM->value]['enabled'] && (null === $v['settings'][Storage::ORM->value]['entity_class'] || !class_exists($v['settings'][Storage::ORM->value]['entity_class'])))
                ->then(function ($v): void {
                    throw new InvalidArgumentException(sprintf('Class "%s" configured in vairogs.settings.orm.entity_class does not exist', $v['settings'][Storage::ORM->value]['entity_class']));
                })
            ->end();
    }

    public function registerConfiguration(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        if (false === $builder->getParameter('vairogs.settings.enabled')) {
            return;
        }

        $container->import(dirname(__DIR__) . '/Resources/config/services.php');
    }
}
