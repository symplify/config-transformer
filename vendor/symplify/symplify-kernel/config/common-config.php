<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310;

use ConfigTransformerPrefix202310\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformerPrefix202310\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use ConfigTransformerPrefix202310\Symplify\SmartFileSystem\FileSystemFilter;
use ConfigTransformerPrefix202310\Symplify\SmartFileSystem\FileSystemGuard;
use ConfigTransformerPrefix202310\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use ConfigTransformerPrefix202310\Symplify\SmartFileSystem\Finder\SmartFinder;
use ConfigTransformerPrefix202310\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformerPrefix202310\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    // symfony style
    $services->set(SymfonyStyleFactory::class);
    $services->set(SymfonyStyle::class)->factory([service(SymfonyStyleFactory::class), 'create']);
    // filesystem
    $services->set(FinderSanitizer::class);
    $services->set(SmartFileSystem::class);
    $services->set(SmartFinder::class);
    $services->set(FileSystemGuard::class);
    $services->set(FileSystemFilter::class);
    $services->set(ParameterProvider::class)->args([service('service_container')]);
    $services->set(PrivatesAccessor::class);
};
