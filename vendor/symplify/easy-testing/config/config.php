<?php

declare (strict_types=1);
namespace ConfigTransformer2021061810;

use ConfigTransformer2021061810\Symfony\Component\Console\Application;
use ConfigTransformer2021061810\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021061810\Symplify\EasyTesting\Console\EasyTestingConsoleApplication;
use ConfigTransformer2021061810\Symplify\PackageBuilder\Console\Command\CommandNaming;
return static function (\ConfigTransformer2021061810\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer2021061810\Symplify\EasyTesting\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/DataProvider', __DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer2021061810\Symplify\EasyTesting\Console\EasyTestingConsoleApplication::class);
    $services->alias(\ConfigTransformer2021061810\Symfony\Component\Console\Application::class, \ConfigTransformer2021061810\Symplify\EasyTesting\Console\EasyTestingConsoleApplication::class);
    $services->set(\ConfigTransformer2021061810\Symplify\PackageBuilder\Console\Command\CommandNaming::class);
};
