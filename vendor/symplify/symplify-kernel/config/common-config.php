<?php

declare (strict_types=1);
namespace ConfigTransformer202108258;

use ConfigTransformer202108258\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer202108258\Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202108258\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer202108258\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202108258\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use ConfigTransformer202108258\Symplify\SmartFileSystem\FileSystemFilter;
use ConfigTransformer202108258\Symplify\SmartFileSystem\FileSystemGuard;
use ConfigTransformer202108258\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use ConfigTransformer202108258\Symplify\SmartFileSystem\Finder\SmartFinder;
use ConfigTransformer202108258\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer202108258\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    // symfony style
    $services->set(\ConfigTransformer202108258\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\ConfigTransformer202108258\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\ConfigTransformer202108258\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202108258\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    // filesystem
    $services->set(\ConfigTransformer202108258\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\ConfigTransformer202108258\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\ConfigTransformer202108258\Symplify\SmartFileSystem\Finder\SmartFinder::class);
    $services->set(\ConfigTransformer202108258\Symplify\SmartFileSystem\FileSystemGuard::class);
    $services->set(\ConfigTransformer202108258\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\ConfigTransformer202108258\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202108258\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202108258\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer202108258\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
