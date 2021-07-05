<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510;

use ConfigTransformer2021070510\PhpParser\ConstExprEvaluator;
use ConfigTransformer2021070510\PhpParser\NodeFinder;
use ConfigTransformer2021070510\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021070510\Symplify\PackageBuilder\Php\TypeChecker;
return static function (\ConfigTransformer2021070510\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('ConfigTransformer2021070510\Symplify\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject']);
    $services->set(\ConfigTransformer2021070510\PhpParser\ConstExprEvaluator::class);
    $services->set(\ConfigTransformer2021070510\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer2021070510\PhpParser\NodeFinder::class);
};
