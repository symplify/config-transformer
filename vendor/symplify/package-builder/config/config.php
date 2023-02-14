<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202302;

use ConfigTransformerPrefix202302\SebastianBergmann\Diff\Differ;
use ConfigTransformerPrefix202302\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformerPrefix202302\Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter;
use ConfigTransformerPrefix202302\Symplify\PackageBuilder\Console\Output\ConsoleDiffer;
use ConfigTransformerPrefix202302\Symplify\PackageBuilder\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use ConfigTransformerPrefix202302\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->set(ColorConsoleDiffFormatter::class);
    $services->set(ConsoleDiffer::class);
    $services->set(CompleteUnifiedDiffOutputBuilderFactory::class);
    $services->set(Differ::class);
    $services->set(PrivatesAccessor::class);
};
