<?php

declare (strict_types=1);
namespace ConfigTransformer202202064\PhpParser\Lexer\TokenEmulator;

use ConfigTransformer202202064\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \ConfigTransformer202202064\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \ConfigTransformer202202064\PhpParser\Lexer\Emulative::PHP_7_4;
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
