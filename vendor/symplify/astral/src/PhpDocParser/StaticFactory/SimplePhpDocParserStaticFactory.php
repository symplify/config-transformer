<?php

declare (strict_types=1);
namespace ConfigTransformer202206079\Symplify\Astral\PhpDocParser\StaticFactory;

use ConfigTransformer202206079\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer202206079\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer202206079\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer202206079\PHPStan\PhpDocParser\Parser\TypeParser;
use ConfigTransformer202206079\Symplify\Astral\PhpDocParser\SimplePhpDocParser;
/**
 * @api
 */
final class SimplePhpDocParserStaticFactory
{
    public static function create() : \ConfigTransformer202206079\Symplify\Astral\PhpDocParser\SimplePhpDocParser
    {
        $phpDocParser = new \ConfigTransformer202206079\PHPStan\PhpDocParser\Parser\PhpDocParser(new \ConfigTransformer202206079\PHPStan\PhpDocParser\Parser\TypeParser(), new \ConfigTransformer202206079\PHPStan\PhpDocParser\Parser\ConstExprParser());
        return new \ConfigTransformer202206079\Symplify\Astral\PhpDocParser\SimplePhpDocParser($phpDocParser, new \ConfigTransformer202206079\PHPStan\PhpDocParser\Lexer\Lexer());
    }
}
