<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symplify\SmartFileSystem\SmartFileSystem;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire()
        ->autoconfigure();

    $services->load('Migrify\ConfigTransformer\FeatureShifter\\', __DIR__ . '/../src')
        ->exclude([__DIR__ . '/../src/Utils/*']);

    $services->set(SmartFileSystem::class);
};
