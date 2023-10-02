<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310;

use ConfigTransformerPrefix202310\SebastianBergmann\Diff\Differ;
use ConfigTransformerPrefix202310\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Console\Output\ConsoleDiffer;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Diff\DifferFactory;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function ConfigTransformerPrefix202310\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->set(ColorConsoleDiffFormatter::class);
    $services->set(ConsoleDiffer::class);
    $services->set(DifferFactory::class);
    $services->set(Differ::class)->factory([service(DifferFactory::class), 'create']);
    $services->set(PrivatesAccessor::class);
};
