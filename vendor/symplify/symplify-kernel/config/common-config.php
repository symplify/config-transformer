<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610;

use ConfigTransformer2022031610\Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2022031610\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer2022031610\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer2022031610\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use ConfigTransformer2022031610\Symplify\SmartFileSystem\FileSystemFilter;
use ConfigTransformer2022031610\Symplify\SmartFileSystem\FileSystemGuard;
use ConfigTransformer2022031610\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use ConfigTransformer2022031610\Symplify\SmartFileSystem\Finder\SmartFinder;
use ConfigTransformer2022031610\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer2022031610\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    // symfony style
    $services->set(\ConfigTransformer2022031610\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\ConfigTransformer2022031610\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\ConfigTransformer2022031610\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer2022031610\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    // filesystem
    $services->set(\ConfigTransformer2022031610\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\ConfigTransformer2022031610\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\ConfigTransformer2022031610\Symplify\SmartFileSystem\Finder\SmartFinder::class);
    $services->set(\ConfigTransformer2022031610\Symplify\SmartFileSystem\FileSystemGuard::class);
    $services->set(\ConfigTransformer2022031610\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\ConfigTransformer2022031610\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer2022031610\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container')]);
    $services->set(\ConfigTransformer2022031610\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
