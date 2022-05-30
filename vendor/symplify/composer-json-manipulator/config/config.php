<?php

declare (strict_types=1);
namespace ConfigTransformer2022053010;

use ConfigTransformer2022053010\Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2022053010\Symplify\ComposerJsonManipulator\ValueObject\Option;
use ConfigTransformer2022053010\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer2022053010\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer2022053010\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use ConfigTransformer2022053010\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer2022053010\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\ConfigTransformer2022053010\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer2022053010\Symplify\ComposerJsonManipulator\\', __DIR__ . '/../src');
    $services->set(\ConfigTransformer2022053010\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\ConfigTransformer2022053010\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\ConfigTransformer2022053010\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer2022053010\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container')]);
    $services->set(\ConfigTransformer2022053010\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\ConfigTransformer2022053010\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\ConfigTransformer2022053010\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer2022053010\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
};
