<?php

declare (strict_types=1);
namespace ConfigTransformer202112075;

use ConfigTransformer202112075\Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202112075\Symplify\ComposerJsonManipulator\ValueObject\Option;
use ConfigTransformer202112075\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer202112075\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202112075\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use ConfigTransformer202112075\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer202112075\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\ConfigTransformer202112075\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202112075\Symplify\ComposerJsonManipulator\\', __DIR__ . '/../src');
    $services->set(\ConfigTransformer202112075\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\ConfigTransformer202112075\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\ConfigTransformer202112075\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202112075\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container')]);
    $services->set(\ConfigTransformer202112075\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\ConfigTransformer202112075\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\ConfigTransformer202112075\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202112075\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
};
