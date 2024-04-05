<?php declare(strict_types = 1);

namespace Vairogs\Component\Settings\DependencyInjection;

use InvalidArgumentException;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Vairogs\Bundle\DependencyInjection\Dependency;
use Vairogs\Bundle\VairogsBundle;
use Vairogs\Component\Settings\Constants\Enum\Storage;

use function class_exists;
use function dirname;
use function sprintf;

final readonly class SettingsConfiguration implements Dependency
{
    public function addSection(ArrayNodeDefinition $rootNode, callable $enableIfStandalone): void
    {
        $rootNode
            ->children()
                ->arrayNode(Dependency::COMPONENT_SETTINGS)
                    ->{$enableIfStandalone(sprintf('%s/%s', VairogsBundle::VAIROGS, Dependency::COMPONENT_SETTINGS), self::class)}()
                    ->children()
                        ->enumNode('storage')->values(Storage::getCases())->defaultValue(Storage::FILE->value)->end()
                        ->arrayNode(Storage::FILE->value)
                            ->canBeEnabled()
                            ->children()
                                ->enumNode('type')->values(['json', 'php', ])->defaultValue('json')->end()
                                ->scalarNode('directory')->defaultValue(sprintf('%%kernel.project_dir%%/var/%s/', VairogsBundle::VAIROGS))->end()
                                ->scalarNode('filename')->defaultValue(Dependency::COMPONENT_SETTINGS)->end()
                            ->end()
                        ->end()
                        ->arrayNode(Storage::ORM->value)
                            ->canBeEnabled()
                            ->children()
                                ->scalarNode('entity_class')->defaultNull()->end()
                            ->end()
                        ->end()
                        ->arrayNode(Storage::MEMORY->value)
                            ->canBeEnabled()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->validate()
                ->ifTrue(fn (array $v) => true)
                ->then(static function (array $v) {
                    foreach (Storage::cases() as $case) {
                        $v[Dependency::COMPONENT_SETTINGS][$case->value][VairogsBundle::ENABLED] =
                            $v[Dependency::COMPONENT_SETTINGS][VairogsBundle::ENABLED]
                            && Storage::from($v[Dependency::COMPONENT_SETTINGS]['storage']) === $case;
                    }

                    return $v;
                })
            ->end()
            ->validate()
                ->ifTrue(static fn (array $v) => $v[Dependency::COMPONENT_SETTINGS][VairogsBundle::ENABLED]
                    && $v[Dependency::COMPONENT_SETTINGS][Storage::ORM->value][VairogsBundle::ENABLED]
                    && (
                        null === $v[Dependency::COMPONENT_SETTINGS][Storage::ORM->value]['entity_class']
                        || !class_exists($v[Dependency::COMPONENT_SETTINGS][Storage::ORM->value]['entity_class'])
                    ),
                )
                ->then(static function (array $v): void {
                    throw new InvalidArgumentException(sprintf('Class "%s" configured in %s.%s.orm.entity_class does not exist', $v[Dependency::COMPONENT_SETTINGS][Storage::ORM->value]['entity_class'], VairogsBundle::VAIROGS, Dependency::COMPONENT_SETTINGS));
                })
            ->end();
    }

    public function registerConfiguration(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        if (!VairogsBundle::enabled($builder, Dependency::COMPONENT_SETTINGS)) {
            return;
        }

        $container->import(dirname(__DIR__) . '/Resources/config/services.php');
    }
}
