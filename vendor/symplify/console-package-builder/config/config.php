<?php

declare (strict_types=1);
namespace ConfigTransformer202106110;

use ConfigTransformer202106110\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\ConfigTransformer202106110\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202106110\Symplify\ConsolePackageBuilder\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle']);
};