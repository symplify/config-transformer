<?php

declare (strict_types=1);
namespace ConfigTransformer2022022410;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2022022410\Symplify\SmartFileSystem\SmartFileSystem;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\ConfigTransformer2022022410\Symplify\SmartFileSystem\SmartFileSystem::class);
};
