<?php declare(strict_types = 1);

namespace Vairogs\Component\Settings\DependencyInjection;

use InvalidArgumentException;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Vairogs\Bundle\DependencyInjection\AbstractDependencyConfiguration;
use Vairogs\Bundle\VairogsBundle;
use Vairogs\Component\Settings\Constants\Enum\Storage;

use function class_exists;
use function sprintf;

final class SettingsConfiguration extends AbstractDependencyConfiguration
{
    public function addSection(
        ArrayNodeDefinition $rootNode,
        callable $enableIfStandalone,
        string $component,
    ): void {
        $rootNode
            ->children()
                ->arrayNode($component)
                    ->{$enableIfStandalone(sprintf('%s/%s', VairogsBundle::VAIROGS, $component), self::class)}()
                    ->children()
                        ->enumNode('storage')->values(Storage::getCases())->defaultValue(Storage::FILE->value)->end()
                        ->arrayNode(Storage::FILE->value)
                            ->canBeEnabled()
                            ->children()
                                ->enumNode('type')->values(['json', 'php', ])->defaultValue('json')->end()
                                ->scalarNode('directory')->defaultValue(sprintf('%%kernel.project_dir%%/var/%s/', VairogsBundle::VAIROGS))->end()
                                ->scalarNode('filename')->defaultValue($component)->end()
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
                ->then(static function (array $v) use ($component) {
                    foreach (Storage::cases() as $case) {
                        $v[$component][$case->value]['enabled'] =
                            $v[$component]['enabled']
                            && Storage::from($v[$component]['storage']) === $case;
                    }

                    return $v;
                })
            ->end()
            ->validate()
                ->ifTrue(
                    static fn (array $v) => $v[$component]['enabled']
                    && $v[$component][Storage::ORM->value]['enabled']
                    && (
                        null === $v[$component][Storage::ORM->value]['entity_class']
                        || !class_exists($v[$component][Storage::ORM->value]['entity_class'])
                    ),
                )
                ->then(static function (array $v) use ($component): void {
                    throw new InvalidArgumentException(sprintf('Class "%s" configured in %s.%s.orm.entity_class does not exist', $v[$component][Storage::ORM->value]['entity_class'], VairogsBundle::VAIROGS, $component));
                })
            ->end();
    }

    public function usesDoctrine(): bool
    {
        return true;
    }
}
