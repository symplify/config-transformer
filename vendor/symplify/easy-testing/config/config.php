<?php

declare (strict_types=1);
namespace ConfigTransformer202107061;

use ConfigTransformer202107061\Symfony\Component\Console\Application;
use ConfigTransformer202107061\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202107061\Symplify\EasyTesting\Console\EasyTestingConsoleApplication;
use ConfigTransformer202107061\Symplify\PackageBuilder\Console\Command\CommandNaming;
return static function (\ConfigTransformer202107061\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202107061\Symplify\EasyTesting\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/DataProvider', __DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer202107061\Symplify\EasyTesting\Console\EasyTestingConsoleApplication::class);
    $services->alias(\ConfigTransformer202107061\Symfony\Component\Console\Application::class, \ConfigTransformer202107061\Symplify\EasyTesting\Console\EasyTestingConsoleApplication::class);
    $services->set(\ConfigTransformer202107061\Symplify\PackageBuilder\Console\Command\CommandNaming::class);
};
