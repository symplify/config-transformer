<?php

declare (strict_types=1);
namespace ConfigTransformer202301\PhpParser\Lexer\TokenEmulator;

use ConfigTransformer202301\PhpParser\Lexer\Emulative;
final class MatchTokenEmulator extends KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return Emulative::PHP_8_0;
    }
    public function getKeywordString() : string
    {
        return 'match';
    }
    public function getKeywordToken() : int
    {
        return \T_MATCH;
    }
}
