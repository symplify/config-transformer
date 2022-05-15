<?php

declare (strict_types=1);
namespace ConfigTransformer202205150;

use ConfigTransformer202205150\Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202205150\Symplify\ComposerJsonManipulator\ValueObject\Option;
use ConfigTransformer202205150\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer202205150\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202205150\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use ConfigTransformer202205150\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer202205150\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\ConfigTransformer202205150\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202205150\Symplify\ComposerJsonManipulator\\', __DIR__ . '/../src');
    $services->set(\ConfigTransformer202205150\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\ConfigTransformer202205150\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\ConfigTransformer202205150\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202205150\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container')]);
    $services->set(\ConfigTransformer202205150\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\ConfigTransformer202205150\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\ConfigTransformer202205150\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202205150\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
};
