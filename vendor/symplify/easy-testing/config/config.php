<?php

declare (strict_types=1);
namespace ConfigTransformer202201308;

use ConfigTransformer202201308\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202201308\Symplify\EasyTesting\Command\ValidateFixtureSkipNamingCommand;
use function ConfigTransformer202201308\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202201308\Symplify\EasyTesting\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/DataProvider', __DIR__ . '/../src/Kernel', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer202201308\Symfony\Component\Console\Application::class)->call('add', [\ConfigTransformer202201308\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202201308\Symplify\EasyTesting\Command\ValidateFixtureSkipNamingCommand::class)]);
};
