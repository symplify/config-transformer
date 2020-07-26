<?php

declare(strict_types=1);

use PhpParser\BuilderFactory;
use PhpParser\NodeFinder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Yaml\Parser;
use Symplify\SmartFileSystem\FileSystemFilter;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire()
        ->autoconfigure();

    $services->load('Migrify\ConfigTransformer\FormatSwitcher\\', __DIR__ . '/../src')
        ->exclude([
            __DIR__ . '/../src/DependencyInjection/Loader/*',
            __DIR__ . '/../src/ValueObject/*',
            // configurable class for faking extensions
            __DIR__ . '/../src/DependencyInjection/Extension/AliasConfigurableExtension.php',
        ]);

    $services->set(BuilderFactory::class);

    $services->set(NodeFinder::class);

    $services->set(Parser::class);

    $services->set(FileSystemFilter::class);
};
