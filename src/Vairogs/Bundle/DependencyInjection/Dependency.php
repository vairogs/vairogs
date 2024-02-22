<?php declare(strict_types = 1);

namespace Vairogs\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

interface Dependency
{
    public function addSection(ArrayNodeDefinition $rootNode, callable $enableIfStandalone): void;

    public function registerConfiguration(ContainerConfigurator $container, ContainerBuilder $builder): void;
}
