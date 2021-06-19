<?php

declare (strict_types=1);
namespace ConfigTransformer2021061910;

use ConfigTransformer2021061910\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer2021061910\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer2021061910\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021061910\Symplify\ComposerJsonManipulator\ValueObject\Option;
use ConfigTransformer2021061910\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer2021061910\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer2021061910\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use ConfigTransformer2021061910\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer2021061910\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\ConfigTransformer2021061910\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\ConfigTransformer2021061910\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer2021061910\Symplify\ComposerJsonManipulator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle']);
    $services->set(\ConfigTransformer2021061910\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\ConfigTransformer2021061910\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\ConfigTransformer2021061910\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer2021061910\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer2021061910\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer2021061910\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\ConfigTransformer2021061910\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\ConfigTransformer2021061910\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer2021061910\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
};
