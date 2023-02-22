<?php

declare(strict_types=1);

use PhpParser\BuilderFactory;
use PhpParser\NodeFinder;
use SebastianBergmann\Diff\Differ;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Yaml\Parser;
use Symplify\ConfigTransformer\Console\ConfigTransformerApplication;
use Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter;
use Symplify\PackageBuilder\Console\Output\ConsoleDiffer;
use Symplify\PackageBuilder\Diff\DifferFactory;
use Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use Symplify\PackageBuilder\Yaml\ParametersMerger;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire();

    $services->load('Symplify\ConfigTransformer\\', __DIR__ . '/../src')
        ->exclude([
            __DIR__ . '/../src/Kernel',
            __DIR__ . '/../src/DependencyInjection/Loader',
            __DIR__ . '/../src/Enum',
            __DIR__ . '/../src/ValueObject',
        ]);

    // console
    $services->alias(Application::class, ConfigTransformerApplication::class);

    // color diff
    $services->set(DifferFactory::class);
    $services->set(Differ::class)
        ->factory([service(DifferFactory::class), 'create']);

    $services->set(ConsoleDiffer::class);

    $services->set(ColorConsoleDiffFormatter::class);

    $services->set(BuilderFactory::class);
    $services->set(NodeFinder::class);
    $services->set(Parser::class);

    $services->set(ClassLikeExistenceChecker::class);
    $services->set(ParametersMerger::class);
};
