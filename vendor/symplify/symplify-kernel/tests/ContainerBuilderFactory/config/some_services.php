<?php

declare (strict_types=1);
namespace ConfigTransformer202202240;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202202240\Symplify\SmartFileSystem\SmartFileSystem;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\ConfigTransformer202202240\Symplify\SmartFileSystem\SmartFileSystem::class);
};
