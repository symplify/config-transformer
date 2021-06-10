<?php

declare (strict_types=1);
namespace ConfigTransformer20210610;

use ConfigTransformer20210610\Symfony\Component\Console\Application;
use ConfigTransformer20210610\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer20210610\Symplify\EasyTesting\Console\EasyTestingConsoleApplication;
use ConfigTransformer20210610\Symplify\PackageBuilder\Console\Command\CommandNaming;
return static function (\ConfigTransformer20210610\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer20210610\Symplify\EasyTesting\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/DataProvider', __DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer20210610\Symplify\EasyTesting\Console\EasyTestingConsoleApplication::class);
    $services->alias(\ConfigTransformer20210610\Symfony\Component\Console\Application::class, \ConfigTransformer20210610\Symplify\EasyTesting\Console\EasyTestingConsoleApplication::class);
    $services->set(\ConfigTransformer20210610\Symplify\PackageBuilder\Console\Command\CommandNaming::class);
};
