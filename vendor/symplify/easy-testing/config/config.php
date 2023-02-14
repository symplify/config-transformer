<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202302;

use ConfigTransformerPrefix202302\Symfony\Component\Console\Application;
use ConfigTransformerPrefix202302\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformerPrefix202302\Symplify\EasyTesting\Command\ValidateFixtureSkipNamingCommand;
use function ConfigTransformerPrefix202302\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->load('Symplify\\EasyTesting\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/DataProvider', __DIR__ . '/../src/Kernel', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(Application::class)->call('add', [service(ValidateFixtureSkipNamingCommand::class)]);
};
