<?php

declare (strict_types=1);
namespace ConfigTransformer202204166;

use ConfigTransformer202204166\Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202204166\Symplify\ComposerJsonManipulator\ValueObject\Option;
use ConfigTransformer202204166\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer202204166\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202204166\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use ConfigTransformer202204166\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer202204166\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\ConfigTransformer202204166\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202204166\Symplify\ComposerJsonManipulator\\', __DIR__ . '/../src');
    $services->set(\ConfigTransformer202204166\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\ConfigTransformer202204166\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\ConfigTransformer202204166\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202204166\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container')]);
    $services->set(\ConfigTransformer202204166\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\ConfigTransformer202204166\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\ConfigTransformer202204166\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202204166\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
};
