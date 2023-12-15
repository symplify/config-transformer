<?php

declare(strict_types=1);

use PhpParser\BuilderFactory;
use PhpParser\NodeFinder;
use SebastianBergmann\Diff\Differ;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Yaml\Parser;
use Symplify\ConfigTransformer\Console\ColorConsoleDiffFormatter;
use Symplify\ConfigTransformer\Console\ConfigTransformerApplication;
use Symplify\ConfigTransformer\Console\ConsoleDiffer;
use Symplify\ConfigTransformer\Console\DifferFactory;
use Symplify\ConfigTransformer\Console\Style\SymfonyStyleFactory;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire()
        ->autoconfigure();

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
    $services->set(Differ::class)
        ->factory([service(DifferFactory::class), 'create']);
    $services->set(ConsoleDiffer::class);
    $services->set(ColorConsoleDiffFormatter::class);

    $services->set(SymfonyStyle::class)
        ->factory([service(SymfonyStyleFactory::class), 'create']);

    $services->set(BuilderFactory::class);
    $services->set(NodeFinder::class);
    $services->set(Parser::class);
};
