<?php

declare (strict_types=1);
namespace ConfigTransformer202211;

use ConfigTransformer202211\SebastianBergmann\Diff\Differ;
use ConfigTransformer202211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202211\Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter;
use ConfigTransformer202211\Symplify\PackageBuilder\Console\Output\ConsoleDiffer;
use ConfigTransformer202211\Symplify\PackageBuilder\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use ConfigTransformer202211\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->set(ColorConsoleDiffFormatter::class);
    $services->set(ConsoleDiffer::class);
    $services->set(CompleteUnifiedDiffOutputBuilderFactory::class);
    $services->set(Differ::class);
    $services->set(PrivatesAccessor::class);
};
