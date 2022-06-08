<?php

declare (strict_types=1);
namespace ConfigTransformer20220608;

use ConfigTransformer20220608\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer20220608\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer20220608\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer20220608\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer20220608\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use ConfigTransformer20220608\Symplify\SmartFileSystem\FileSystemFilter;
use ConfigTransformer20220608\Symplify\SmartFileSystem\FileSystemGuard;
use ConfigTransformer20220608\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use ConfigTransformer20220608\Symplify\SmartFileSystem\Finder\SmartFinder;
use ConfigTransformer20220608\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer20220608\Symfony\Component\DependencyInjection\Loader\Configurator\service;
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
