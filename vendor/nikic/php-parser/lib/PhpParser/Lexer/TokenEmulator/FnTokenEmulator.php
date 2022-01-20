<?php

declare (strict_types=1);
namespace ConfigTransformer202201207\PhpParser\Lexer\TokenEmulator;

use ConfigTransformer202201207\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \ConfigTransformer202201207\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \ConfigTransformer202201207\PhpParser\Lexer\Emulative::PHP_7_4;
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
