<?php

declare (strict_types=1);
namespace ConfigTransformer2022030710\Symplify\Astral\PhpDocParser\StaticFactory;

use ConfigTransformer2022030710\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer2022030710\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer2022030710\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer2022030710\PHPStan\PhpDocParser\Parser\TypeParser;
use ConfigTransformer2022030710\Symplify\Astral\PhpDocParser\SimplePhpDocParser;
/**
 * @api
 */
final class SimplePhpDocParserStaticFactory
{
    public static function create() : \ConfigTransformer2022030710\Symplify\Astral\PhpDocParser\SimplePhpDocParser
    {
        $phpDocParser = new \ConfigTransformer2022030710\PHPStan\PhpDocParser\Parser\PhpDocParser(new \ConfigTransformer2022030710\PHPStan\PhpDocParser\Parser\TypeParser(), new \ConfigTransformer2022030710\PHPStan\PhpDocParser\Parser\ConstExprParser());
        return new \ConfigTransformer2022030710\Symplify\Astral\PhpDocParser\SimplePhpDocParser($phpDocParser, new \ConfigTransformer2022030710\PHPStan\PhpDocParser\Lexer\Lexer());
    }
}
