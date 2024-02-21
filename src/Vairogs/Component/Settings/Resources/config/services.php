<?php declare(strict_types = 1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load(namespace: 'Vairogs\\Components\\Settings\\', resource: __DIR__ . '/../*')
        ->exclude(excludes: [__DIR__ . '/../{Entity}']);
};
