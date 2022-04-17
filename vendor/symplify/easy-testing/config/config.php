<?php

declare (strict_types=1);
namespace ConfigTransformer202204179;

use ConfigTransformer202204179\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202204179\Symplify\EasyTesting\Command\ValidateFixtureSkipNamingCommand;
use function ConfigTransformer202204179\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202204179\Symplify\EasyTesting\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/DataProvider', __DIR__ . '/../src/Kernel', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer202204179\Symfony\Component\Console\Application::class)->call('add', [\ConfigTransformer202204179\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202204179\Symplify\EasyTesting\Command\ValidateFixtureSkipNamingCommand::class)]);
};
