<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202507\PhpParser\Lexer\TokenEmulator;

use ConfigTransformerPrefix202507\PhpParser\PhpVersion;
use ConfigTransformerPrefix202507\PhpParser\Token;
/** @internal */
abstract class TokenEmulator
{
    public abstract function getPhpVersion() : PhpVersion;
    public abstract function isEmulationNeeded(string $code) : bool;
    /**
     * @param Token[] $tokens Original tokens
     * @return Token[] Modified Tokens
     */
    public abstract function emulate(string $code, array $tokens) : array;
    /**
     * @param Token[] $tokens Original tokens
     * @return Token[] Modified Tokens
     */
    public abstract function reverseEmulate(string $code, array $tokens) : array;
    /** @param array{int, string, string}[] $patches */
    public function preprocessCode(string $code, array &$patches) : string
    {
        return $code;
    }
}
