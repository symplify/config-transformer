<?php

declare (strict_types=1);
namespace ConfigTransformer202207\PhpParser\Lexer\TokenEmulator;

use ConfigTransformer202207\PhpParser\Lexer\Emulative;
final class ReadonlyTokenEmulator extends KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return Emulative::PHP_8_1;
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
