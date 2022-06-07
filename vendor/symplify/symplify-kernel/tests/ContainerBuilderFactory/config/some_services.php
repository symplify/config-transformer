<?php

declare (strict_types=1);
namespace ConfigTransformer202206079;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202206079\Symplify\SmartFileSystem\SmartFileSystem;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\ConfigTransformer202206079\Symplify\SmartFileSystem\SmartFileSystem::class);
};
