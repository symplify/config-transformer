<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210;

use ConfigTransformer2021062210\PhpParser\BuilderFactory;
use ConfigTransformer2021062210\PhpParser\NodeFinder;
use ConfigTransformer2021062210\Symfony\Component\Console\Application;
use ConfigTransformer2021062210\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021062210\Symfony\Component\Yaml\Parser;
use ConfigTransformer2021062210\Symplify\ConfigTransformer\Configuration\Configuration;
use ConfigTransformer2021062210\Symplify\ConfigTransformer\Console\ConfigTransfomerConsoleApplication;
use ConfigTransformer2021062210\Symplify\ConfigTransformer\Provider\YamlContentProvider;
use ConfigTransformer2021062210\Symplify\PackageBuilder\Console\Command\CommandNaming;
use ConfigTransformer2021062210\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
use ConfigTransformer2021062210\Symplify\SmartFileSystem\FileSystemFilter;
return static function (\ConfigTransformer2021062210\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer2021062210\Symplify\ConfigTransformer\\', __DIR__ . '/../src')->exclude([
        __DIR__ . '/../src/HttpKernel',
        __DIR__ . '/../src/DependencyInjection/Loader',
        __DIR__ . '/../src/ValueObject',
        // configurable class for faking extensions
        __DIR__ . '/../src/DependencyInjection/Extension/AliasConfigurableExtension.php',
    ]);
    // console
    $services->set(\ConfigTransformer2021062210\Symplify\ConfigTransformer\Console\ConfigTransfomerConsoleApplication::class);
    $services->alias(\ConfigTransformer2021062210\Symfony\Component\Console\Application::class, \ConfigTransformer2021062210\Symplify\ConfigTransformer\Console\ConfigTransfomerConsoleApplication::class);
    $services->set(\ConfigTransformer2021062210\Symplify\PackageBuilder\Console\Command\CommandNaming::class);
    $services->set(\ConfigTransformer2021062210\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer2021062210\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer2021062210\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer2021062210\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->alias(\ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class, \ConfigTransformer2021062210\Symplify\ConfigTransformer\Configuration\Configuration::class);
    $services->alias(\ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \ConfigTransformer2021062210\Symplify\ConfigTransformer\Provider\YamlContentProvider::class);
    $services->set(\ConfigTransformer2021062210\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
