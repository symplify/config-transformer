<?php

declare (strict_types=1);
namespace ConfigTransformer202107050;

use ConfigTransformer202107050\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\ConfigTransformer202107050\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202107050\Symplify\ConsolePackageBuilder\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle']);
};
