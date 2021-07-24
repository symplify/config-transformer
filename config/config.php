<?php

declare (strict_types=1);
namespace ConfigTransformer202107246;

use ConfigTransformer202107246\PhpParser\BuilderFactory;
use ConfigTransformer202107246\PhpParser\NodeFinder;
use ConfigTransformer202107246\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202107246\Symfony\Component\Yaml\Parser;
use ConfigTransformer202107246\Symplify\ConfigTransformer\Configuration\Configuration;
use ConfigTransformer202107246\Symplify\ConfigTransformer\Console\ConfigTransfomerConsoleApplication;
use ConfigTransformer202107246\Symplify\ConfigTransformer\Provider\YamlContentProvider;
use ConfigTransformer202107246\Symplify\PackageBuilder\Console\Command\CommandNaming;
use ConfigTransformer202107246\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use ConfigTransformer202107246\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use ConfigTransformer202107246\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
use ConfigTransformer202107246\Symplify\SmartFileSystem\FileSystemFilter;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202107246\Symplify\ConfigTransformer\\', __DIR__ . '/../src')->exclude([
        __DIR__ . '/../src/HttpKernel',
        __DIR__ . '/../src/DependencyInjection/Loader',
        __DIR__ . '/../src/ValueObject',
        // configurable class for faking extensions
        __DIR__ . '/../src/DependencyInjection/Extension/AliasConfigurableExtension.php',
    ]);
    // console
    $services->set(\ConfigTransformer202107246\Symplify\ConfigTransformer\Console\ConfigTransfomerConsoleApplication::class);
    $services->alias(\ConfigTransformer202107246\Symfony\Component\Console\Application::class, \ConfigTransformer202107246\Symplify\ConfigTransformer\Console\ConfigTransfomerConsoleApplication::class);
    $services->set(\ConfigTransformer202107246\Symplify\PackageBuilder\Console\Command\CommandNaming::class);
    $services->set(\ConfigTransformer202107246\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202107246\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202107246\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202107246\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->alias(\ConfigTransformer202107246\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class, \ConfigTransformer202107246\Symplify\ConfigTransformer\Configuration\Configuration::class);
    $services->alias(\ConfigTransformer202107246\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \ConfigTransformer202107246\Symplify\ConfigTransformer\Provider\YamlContentProvider::class);
    $services->set(\ConfigTransformer202107246\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
