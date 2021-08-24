<?php

declare (strict_types=1);
namespace ConfigTransformer2021082410\PhpParser\Lexer\TokenEmulator;

use ConfigTransformer2021082410\PhpParser\Lexer\Emulative;
final class ReadonlyTokenEmulator extends \ConfigTransformer2021082410\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \ConfigTransformer2021082410\PhpParser\Lexer\Emulative::PHP_8_1;
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
