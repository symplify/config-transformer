<?php

declare (strict_types=1);
namespace ConfigTransformer2021120210;

use ConfigTransformer2021120210\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021120210\Symplify\EasyTesting\Console\EasyTestingConsoleApplication;
use ConfigTransformer2021120210\Symplify\PackageBuilder\Console\Command\CommandNaming;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer2021120210\Symplify\EasyTesting\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/DataProvider', __DIR__ . '/../src/Kernel', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer2021120210\Symplify\EasyTesting\Console\EasyTestingConsoleApplication::class);
    $services->alias(\ConfigTransformer2021120210\Symfony\Component\Console\Application::class, \ConfigTransformer2021120210\Symplify\EasyTesting\Console\EasyTestingConsoleApplication::class);
    $services->set(\ConfigTransformer2021120210\Symplify\PackageBuilder\Console\Command\CommandNaming::class);
};
