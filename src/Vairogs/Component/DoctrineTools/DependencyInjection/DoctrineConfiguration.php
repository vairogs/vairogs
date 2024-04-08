<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Vairogs\Bundle\DependencyInjection\Dependency;
use Vairogs\Bundle\VairogsBundle;

use function dirname;
use function sprintf;

final readonly class DoctrineConfiguration implements Dependency
{
    public function addSection(
        ArrayNodeDefinition $rootNode,
        callable $enableIfStandalone,
    ): void {
        $rootNode
            ->children()
            ->arrayNode(Dependency::COMPONENT_DOCTRINE)
            ->{$enableIfStandalone(sprintf('%s/%s', VairogsBundle::VAIROGS, Dependency::COMPONENT_DOCTRINE), self::class)}()
        ->end();
    }

    public function registerConfiguration(
        ContainerConfigurator $container,
        ContainerBuilder $builder,
    ): void {
        if (!VairogsBundle::enabled($builder, Dependency::COMPONENT_DOCTRINE)) {
            return;
        }

        $container->import(dirname(__DIR__) . '/Resources/config/services.php');
    }
}
