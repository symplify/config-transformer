<?php

declare (strict_types=1);
namespace ConfigTransformer2022022410;

use ConfigTransformer2022022410\PhpParser\ConstExprEvaluator;
use ConfigTransformer2022022410\PhpParser\NodeFinder;
use ConfigTransformer2022022410\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer2022022410\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer2022022410\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer2022022410\PHPStan\PhpDocParser\Parser\TypeParser;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2022022410\Symplify\Astral\PhpParser\SmartPhpParser;
use ConfigTransformer2022022410\Symplify\Astral\PhpParser\SmartPhpParserFactory;
use ConfigTransformer2022022410\Symplify\PackageBuilder\Php\TypeChecker;
use function ConfigTransformer2022022410\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('ConfigTransformer2022022410\Symplify\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/NodeVisitor', __DIR__ . '/../src/PhpParser/SmartPhpParser.php', __DIR__ . '/../src/PhpDocParser/PhpDocNodeVisitor/CallablePhpDocNodeVisitor.php']);
    $services->set(\ConfigTransformer2022022410\Symplify\Astral\PhpParser\SmartPhpParser::class)->factory([\ConfigTransformer2022022410\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer2022022410\Symplify\Astral\PhpParser\SmartPhpParserFactory::class), 'create']);
    $services->set(\ConfigTransformer2022022410\PhpParser\ConstExprEvaluator::class);
    $services->set(\ConfigTransformer2022022410\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer2022022410\PhpParser\NodeFinder::class);
    // phpdoc parser
    $services->set(\ConfigTransformer2022022410\PHPStan\PhpDocParser\Parser\PhpDocParser::class);
    $services->set(\ConfigTransformer2022022410\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->set(\ConfigTransformer2022022410\PHPStan\PhpDocParser\Parser\TypeParser::class);
    $services->set(\ConfigTransformer2022022410\PHPStan\PhpDocParser\Parser\ConstExprParser::class);
};
