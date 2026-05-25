<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202605\PhpParser\Lexer\TokenEmulator;

use ConfigTransformerPrefix202605\PhpParser\PhpVersion;
final class PropertyTokenEmulator extends KeywordEmulator
{
    public function getPhpVersion() : PhpVersion
    {
        return PhpVersion::fromComponents(8, 4);
    }
    public function getKeywordString() : string
    {
        return '__property__';
    }
    public function getKeywordToken() : int
    {
        return \ConfigTransformerPrefix202605\T_PROPERTY_C;
    }
}
