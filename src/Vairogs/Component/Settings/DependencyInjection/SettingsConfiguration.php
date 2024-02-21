<?php declare(strict_types=1);

namespace Vairogs\Component\Settings\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Vairogs\Bundle\DependencyInjection\Dependency;

final readonly class SettingsConfiguration implements Dependency
{
    public function addSection(ArrayNodeDefinition $rootNode, callable $enableIfStandalone): void {
        $rootNode
            ->children()
                ->arrayNode('settings')
                    ->info('Settings configuration')
                    ->{$enableIfStandalone('vairogs/settings', self::class)}()
                ->end()
            ->end();
    }

    public function registerConfiguration(ContainerConfigurator $container, ContainerBuilder $builder): void{
        if(false === $builder->getParameter('vairogs.settings.enabled')) {
            return;
        }

        $container->import(__DIR__.'/../Resources/config/services.php');
    }
}
