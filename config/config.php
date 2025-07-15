<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202507;

use ConfigTransformerPrefix202507\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformerPrefix202507\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\ConfigTransformer\Console\Style\SymfonyStyleFactory;
use function ConfigTransformerPrefix202507\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ConfigTransformer\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Kernel', __DIR__ . '/../src/DependencyInjection/Loader', __DIR__ . '/../src/Enum', __DIR__ . '/../src/ValueObject']);
    $services->set(SymfonyStyle::class)->factory([service(SymfonyStyleFactory::class), 'create']);
};
