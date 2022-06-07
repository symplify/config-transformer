<?php

declare (strict_types=1);
namespace ConfigTransformer202206079;

use ConfigTransformer202206079\PhpParser\ConstExprEvaluator;
use ConfigTransformer202206079\PhpParser\NodeFinder;
use ConfigTransformer202206079\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer202206079\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer202206079\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer202206079\PHPStan\PhpDocParser\Parser\TypeParser;
use ConfigTransformer202206079\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202206079\Symplify\Astral\PhpParser\SmartPhpParser;
use ConfigTransformer202206079\Symplify\Astral\PhpParser\SmartPhpParserFactory;
use ConfigTransformer202206079\Symplify\PackageBuilder\Php\TypeChecker;
use function ConfigTransformer202206079\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public();
    $services->load('Symplify\\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/NodeVisitor', __DIR__ . '/../src/PhpParser/SmartPhpParser.php', __DIR__ . '/../src/PhpDocParser/PhpDocNodeVisitor/CallablePhpDocNodeVisitor.php']);
    $services->set(SmartPhpParser::class)->factory([service(SmartPhpParserFactory::class), 'create']);
    $services->set(ConstExprEvaluator::class);
    $services->set(TypeChecker::class);
    $services->set(NodeFinder::class);
    // phpdoc parser
    $services->set(PhpDocParser::class);
    $services->set(Lexer::class);
    $services->set(TypeParser::class);
    $services->set(ConstExprParser::class);
};
