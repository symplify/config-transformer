<?php

declare (strict_types=1);
namespace ConfigTransformer202106249;

use ConfigTransformer202106249\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\ConfigTransformer202106249\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202106249\Symplify\ConsolePackageBuilder\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle']);
};
