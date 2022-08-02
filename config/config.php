<?php

declare (strict_types=1);
namespace ConfigTransformer202208;

use ConfigTransformer202208\PhpParser\BuilderFactory;
use ConfigTransformer202208\PhpParser\NodeFinder;
use ConfigTransformer202208\SebastianBergmann\Diff\Differ;
use ConfigTransformer202208\Symfony\Component\Console\Application;
use ConfigTransformer202208\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202208\Symfony\Component\Yaml\Parser;
use Symplify\ConfigTransformer\Console\ConfigTransformerApplication;
use ConfigTransformer202208\Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter;
use ConfigTransformer202208\Symplify\PackageBuilder\Console\Output\ConsoleDiffer;
use ConfigTransformer202208\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use ConfigTransformer202208\Symplify\PackageBuilder\Yaml\ParametersMerger;
use ConfigTransformer202208\Symplify\SmartFileSystem\FileSystemFilter;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->load('Symplify\\ConfigTransformer\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Kernel', __DIR__ . '/../src/DependencyInjection/Loader', __DIR__ . '/../src/Enum', __DIR__ . '/../src/ValueObject']);
    // console
    $services->alias(Application::class, ConfigTransformerApplication::class);
    // color diff
    $services->set(ConsoleDiffer::class);
    $services->set(Differ::class);
    $services->set(ColorConsoleDiffFormatter::class);
    $services->set(BuilderFactory::class);
    $services->set(NodeFinder::class);
    $services->set(Parser::class);
    $services->set(FileSystemFilter::class);
    $services->set(ClassLikeExistenceChecker::class);
    $services->set(ParametersMerger::class);
};
