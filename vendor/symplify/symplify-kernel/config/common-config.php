<?php

declare (strict_types=1);
namespace ConfigTransformer2021082410;

use ConfigTransformer2021082410\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer2021082410\Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021082410\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer2021082410\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer2021082410\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use ConfigTransformer2021082410\Symplify\SmartFileSystem\FileSystemFilter;
use ConfigTransformer2021082410\Symplify\SmartFileSystem\FileSystemGuard;
use ConfigTransformer2021082410\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use ConfigTransformer2021082410\Symplify\SmartFileSystem\Finder\SmartFinder;
use ConfigTransformer2021082410\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer2021082410\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    // symfony style
    $services->set(\ConfigTransformer2021082410\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\ConfigTransformer2021082410\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\ConfigTransformer2021082410\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer2021082410\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    // filesystem
    $services->set(\ConfigTransformer2021082410\Symplify\SmartFileSystem\Finder\FinderSanitizer::class);
    $services->set(\ConfigTransformer2021082410\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\ConfigTransformer2021082410\Symplify\SmartFileSystem\Finder\SmartFinder::class);
    $services->set(\ConfigTransformer2021082410\Symplify\SmartFileSystem\FileSystemGuard::class);
    $services->set(\ConfigTransformer2021082410\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\ConfigTransformer2021082410\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer2021082410\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer2021082410\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer2021082410\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
