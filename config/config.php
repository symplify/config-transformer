<?php

declare(strict_types=1);

use Migrify\ConfigTransformer\FormatSwitcher\Configuration\Configuration;
use Migrify\ConfigTransformer\FormatSwitcher\Provider\YamlContentProvider;
use Migrify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use Migrify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\SmartFileSystem;
use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/../packages/**/config/**.php');

    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire()
        ->autoconfigure();

    $services->load('Migrify\ConfigTransformer\\', __DIR__ . '/../src')
        ->exclude([__DIR__ . '/../src/HttpKernel/*']);

    $services->set(FinderSanitizer::class);

    $services->set(PrivatesAccessor::class);

    $services->set(SmartFileSystem::class);

    $services->set(SymfonyStyleFactory::class);

    $services->set(SymfonyStyle::class)
        ->factory([ref(SymfonyStyleFactory::class), 'create']);

    $services->alias(SymfonyVersionFeatureGuardInterface::class, Configuration::class);

    $services->alias(YamlFileContentProviderInterface::class, YamlContentProvider::class);
};
