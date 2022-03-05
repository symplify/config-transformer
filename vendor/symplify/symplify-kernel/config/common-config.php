<?php

declare (strict_types=1);
namespace ConfigTransformer202203054;

use ConfigTransformer202203054\Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202203054\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer202203054\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202203054\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use ConfigTransformer202203054\Symplify\SmartFileSystem\FileSystemFilter;
use ConfigTransformer202203054\Symplify\SmartFileSystem\FileSystemGuard;
use ConfigTransformer202203054\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use ConfigTransformer202203054\Symplify\SmartFileSystem\Finder\SmartFinder;
use ConfigTransformer202203054\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer202203054\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    // symfony style
    $services->set(\ConfigTransformer202203054\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\ConfigTransformer202203054\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\ConfigTransformer202203054\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202203054\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    // filesystem
    $services->set(\ConfigTransformer202203054\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\ConfigTransformer202203054\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\ConfigTransformer202203054\Symplify\SmartFileSystem\Finder\SmartFinder::class);
    $services->set(\ConfigTransformer202203054\Symplify\SmartFileSystem\FileSystemGuard::class);
    $services->set(\ConfigTransformer202203054\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\ConfigTransformer202203054\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202203054\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container')]);
    $services->set(\ConfigTransformer202203054\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
