<?php

declare (strict_types=1);
namespace ConfigTransformer202108234\PhpParser\Lexer\TokenEmulator;

use ConfigTransformer202108234\PhpParser\Lexer\Emulative;
final class ReadonlyTokenEmulator extends \ConfigTransformer202108234\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \ConfigTransformer202108234\PhpParser\Lexer\Emulative::PHP_8_1;
    }
    public function getKeywordString() : string
    {
        return 'readonly';
    }
    public function getKeywordToken() : int
    {
        return \T_READONLY;
    }
}
