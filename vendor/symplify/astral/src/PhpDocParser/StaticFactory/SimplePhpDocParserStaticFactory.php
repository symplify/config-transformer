<?php

declare (strict_types=1);
namespace ConfigTransformer20220607\Symplify\Astral\PhpDocParser\StaticFactory;

use ConfigTransformer20220607\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer20220607\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer20220607\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer20220607\PHPStan\PhpDocParser\Parser\TypeParser;
use ConfigTransformer20220607\Symplify\Astral\PhpDocParser\SimplePhpDocParser;
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
