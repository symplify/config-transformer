<?php

declare(strict_types=1);

use Migrify\ConfigTransformer\Configuration\Configuration;
use Migrify\ConfigTransformer\Provider\YamlContentProvider;
use Migrify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use Migrify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
use PhpParser\BuilderFactory;
use PhpParser\NodeFinder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Yaml\Parser;
use Symplify\SmartFileSystem\FileSystemFilter;

return static function (ContainerConfigurator $containerConfigurator): void {
    // monorepo
    $containerConfigurator->import(
        __DIR__ . '/../../../packages/php-config-printer/config/config.php',
        null,
        'not_found'
    );

    // dependency
    $containerConfigurator->import(__DIR__ . '/../../php-config-printer/config/config.php', null, 'not_found');

    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire()
        ->autoconfigure();

    $services->load('Migrify\ConfigTransformer\\', __DIR__ . '/../src')
        ->exclude([
            __DIR__ . '/../src/HttpKernel',
            __DIR__ . '/../src/DependencyInjection/Loader',
            __DIR__ . '/../src/ValueObject',
            // configurable class for faking extensions
            __DIR__ . '/../src/DependencyInjection/Extension/AliasConfigurableExtension.php',
        ]);

    $services->set(BuilderFactory::class);
    $services->set(NodeFinder::class);
    $services->set(Parser::class);
    $services->set(FileSystemFilter::class);

    $services->alias(SymfonyVersionFeatureGuardInterface::class, Configuration::class);
    $services->alias(YamlFileContentProviderInterface::class, YamlContentProvider::class);
};
