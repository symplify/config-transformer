<?php

declare (strict_types=1);
namespace ConfigTransformer202112190\PhpParser\Lexer\TokenEmulator;

use ConfigTransformer202112190\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \ConfigTransformer202112190\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \ConfigTransformer202112190\PhpParser\Lexer\Emulative::PHP_7_4;
    }
    public function getKeywordString() : string
    {
        return 'fn';
    }
    public function getKeywordToken() : int
    {
        return \T_FN;
    }
}
