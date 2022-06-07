<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\Astral\PhpDocParser\StaticFactory;

use ConfigTransformer2022060710\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer2022060710\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer2022060710\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer2022060710\PHPStan\PhpDocParser\Parser\TypeParser;
use ConfigTransformer2022060710\Symplify\Astral\PhpDocParser\SimplePhpDocParser;
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
