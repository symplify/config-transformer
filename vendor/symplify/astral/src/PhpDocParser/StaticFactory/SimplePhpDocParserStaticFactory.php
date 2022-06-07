<?php

declare (strict_types=1);
namespace ConfigTransformer202206072\Symplify\Astral\PhpDocParser\StaticFactory;

use ConfigTransformer202206072\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer202206072\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer202206072\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer202206072\PHPStan\PhpDocParser\Parser\TypeParser;
use ConfigTransformer202206072\Symplify\Astral\PhpDocParser\SimplePhpDocParser;
/**
 * @api
 */
final class SimplePhpDocParserStaticFactory
{
    public static function create() : SimplePhpDocParser
    {
        $phpDocParser = new PhpDocParser(new TypeParser(), new ConstExprParser());
        return new SimplePhpDocParser($phpDocParser, new Lexer());
    }
}
