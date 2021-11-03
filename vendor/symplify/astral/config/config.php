<?php

declare (strict_types=1);
namespace ConfigTransformer2021110310;

use ConfigTransformer2021110310\PhpParser\ConstExprEvaluator;
use ConfigTransformer2021110310\PhpParser\NodeFinder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021110310\Symplify\Astral\PhpParser\SmartPhpParser;
use ConfigTransformer2021110310\Symplify\Astral\PhpParser\SmartPhpParserFactory;
use ConfigTransformer2021110310\Symplify\PackageBuilder\Php\TypeChecker;
use function ConfigTransformer2021110310\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('ConfigTransformer2021110310\Symplify\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/NodeVisitor', __DIR__ . '/../src/PhpParser/SmartPhpParser.php']);
    $services->set(\ConfigTransformer2021110310\Symplify\Astral\PhpParser\SmartPhpParser::class)->factory([\ConfigTransformer2021110310\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer2021110310\Symplify\Astral\PhpParser\SmartPhpParserFactory::class), 'create']);
    $services->set(\ConfigTransformer2021110310\PhpParser\ConstExprEvaluator::class);
    $services->set(\ConfigTransformer2021110310\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer2021110310\PhpParser\NodeFinder::class);
};
