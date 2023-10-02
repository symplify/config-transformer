<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310;

use ConfigTransformerPrefix202310\PhpParser\BuilderFactory;
use ConfigTransformerPrefix202310\PhpParser\NodeFinder;
use ConfigTransformerPrefix202310\SebastianBergmann\Diff\Differ;
use ConfigTransformerPrefix202310\Symfony\Component\Console\Application;
use ConfigTransformerPrefix202310\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformerPrefix202310\Symfony\Component\Yaml\Parser;
use Symplify\ConfigTransformer\Console\ConfigTransformerApplication;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Console\Output\ConsoleDiffer;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Diff\DifferFactory;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Yaml\ParametersMerger;
use function ConfigTransformerPrefix202310\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->load('Symplify\\ConfigTransformer\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Kernel', __DIR__ . '/../src/DependencyInjection/Loader', __DIR__ . '/../src/Enum', __DIR__ . '/../src/ValueObject']);
    // console
    $services->alias(Application::class, ConfigTransformerApplication::class);
    // color diff
    $services->set(DifferFactory::class);
    $services->set(Differ::class)->factory([service(DifferFactory::class), 'create']);
    $services->set(ConsoleDiffer::class);
    $services->set(ColorConsoleDiffFormatter::class);
    $services->set(BuilderFactory::class);
    $services->set(NodeFinder::class);
    $services->set(Parser::class);
    $services->set(ClassLikeExistenceChecker::class);
    $services->set(ParametersMerger::class);
};
