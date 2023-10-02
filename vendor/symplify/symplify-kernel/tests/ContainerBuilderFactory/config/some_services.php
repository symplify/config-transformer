<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310;

use ConfigTransformerPrefix202310\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformerPrefix202310\Symplify\SmartFileSystem\SmartFileSystem;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(SmartFileSystem::class);
};
