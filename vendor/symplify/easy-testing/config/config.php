<?php

declare (strict_types=1);
namespace ConfigTransformer202206052;

use ConfigTransformer202206052\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202206052\Symplify\EasyTesting\Command\ValidateFixtureSkipNamingCommand;
use function ConfigTransformer202206052\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202206052\Symplify\EasyTesting\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/DataProvider', __DIR__ . '/../src/Kernel', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer202206052\Symfony\Component\Console\Application::class)->call('add', [\ConfigTransformer202206052\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202206052\Symplify\EasyTesting\Command\ValidateFixtureSkipNamingCommand::class)]);
};
