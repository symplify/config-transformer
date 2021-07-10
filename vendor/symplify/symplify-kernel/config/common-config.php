<?php

declare (strict_types=1);
namespace ConfigTransformer202107101;

use ConfigTransformer202107101\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer202107101\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer202107101\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202107101\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer202107101\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202107101\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use ConfigTransformer202107101\Symplify\SmartFileSystem\FileSystemFilter;
use ConfigTransformer202107101\Symplify\SmartFileSystem\FileSystemGuard;
use ConfigTransformer202107101\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use ConfigTransformer202107101\Symplify\SmartFileSystem\Finder\SmartFinder;
use ConfigTransformer202107101\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer202107101\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\ConfigTransformer202107101\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    // symfony style
    $services->set(\ConfigTransformer202107101\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\ConfigTransformer202107101\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\ConfigTransformer202107101\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202107101\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    // filesystem
    $services->set(\ConfigTransformer202107101\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\ConfigTransformer202107101\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\ConfigTransformer202107101\Symplify\SmartFileSystem\Finder\SmartFinder::class);
    $services->set(\ConfigTransformer202107101\Symplify\SmartFileSystem\FileSystemGuard::class);
    $services->set(\ConfigTransformer202107101\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\ConfigTransformer202107101\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202107101\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202107101\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer202107101\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
