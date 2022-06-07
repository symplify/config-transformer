<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\PhpParser\Lexer\TokenEmulator;

use ConfigTransformer2022060710\PhpParser\Lexer\Emulative;
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
