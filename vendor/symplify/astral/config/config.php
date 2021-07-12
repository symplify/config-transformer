<?php

declare (strict_types=1);
namespace ConfigTransformer202107121;

use ConfigTransformer202107121\PhpParser\ConstExprEvaluator;
use ConfigTransformer202107121\PhpParser\NodeFinder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202107121\Symplify\PackageBuilder\Php\TypeChecker;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('ConfigTransformer202107121\Symplify\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject']);
    $services->set(\ConfigTransformer202107121\PhpParser\ConstExprEvaluator::class);
    $services->set(\ConfigTransformer202107121\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer202107121\PhpParser\NodeFinder::class);
};
