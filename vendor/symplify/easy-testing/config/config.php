<?php

declare (strict_types=1);
namespace ConfigTransformer202204175;

use ConfigTransformer202204175\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202204175\Symplify\EasyTesting\Command\ValidateFixtureSkipNamingCommand;
use function ConfigTransformer202204175\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202204175\Symplify\EasyTesting\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/DataProvider', __DIR__ . '/../src/Kernel', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer202204175\Symfony\Component\Console\Application::class)->call('add', [\ConfigTransformer202204175\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202204175\Symplify\EasyTesting\Command\ValidateFixtureSkipNamingCommand::class)]);
};
