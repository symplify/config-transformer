<?php

declare (strict_types=1);
namespace ConfigTransformer202111277;

use ConfigTransformer202111277\PhpParser\BuilderFactory;
use ConfigTransformer202111277\PhpParser\NodeFinder;
use ConfigTransformer202111277\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202111277\Symfony\Component\Yaml\Parser;
use ConfigTransformer202111277\Symplify\ConfigTransformer\Console\ConfigTransfomerConsoleApplication;
use ConfigTransformer202111277\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use ConfigTransformer202111277\Symplify\PackageBuilder\Yaml\ParametersMerger;
use ConfigTransformer202111277\Symplify\SmartFileSystem\FileSystemFilter;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202111277\Symplify\ConfigTransformer\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Kernel', __DIR__ . '/../src/DependencyInjection/Loader', __DIR__ . '/../src/Enum', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer202111277\Symplify\ConfigTransformer\Console\ConfigTransfomerConsoleApplication::class);
    $services->alias(\ConfigTransformer202111277\Symfony\Component\Console\Application::class, \ConfigTransformer202111277\Symplify\ConfigTransformer\Console\ConfigTransfomerConsoleApplication::class);
    $services->set(\ConfigTransformer202111277\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202111277\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202111277\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202111277\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\ConfigTransformer202111277\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
    $services->set(\ConfigTransformer202111277\Symplify\PackageBuilder\Yaml\ParametersMerger::class);
};
