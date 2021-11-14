<?php

declare (strict_types=1);
namespace ConfigTransformer202111140;

use ConfigTransformer202111140\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202111140\Symplify\EasyTesting\Console\EasyTestingConsoleApplication;
use ConfigTransformer202111140\Symplify\PackageBuilder\Console\Command\CommandNaming;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202111140\Symplify\EasyTesting\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/DataProvider', __DIR__ . '/../src/Kernel', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer202111140\Symplify\EasyTesting\Console\EasyTestingConsoleApplication::class);
    $services->alias(\ConfigTransformer202111140\Symfony\Component\Console\Application::class, \ConfigTransformer202111140\Symplify\EasyTesting\Console\EasyTestingConsoleApplication::class);
    $services->set(\ConfigTransformer202111140\Symplify\PackageBuilder\Console\Command\CommandNaming::class);
};
