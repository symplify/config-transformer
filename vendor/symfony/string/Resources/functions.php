<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202202152\Symfony\Component\String;

if (!\function_exists(\ConfigTransformer202202152\Symfony\Component\String\u::class)) {
    function u(?string $string = '') : \ConfigTransformer202202152\Symfony\Component\String\UnicodeString
    {
        return new \ConfigTransformer202202152\Symfony\Component\String\UnicodeString($string ?? '');
    }
}
if (!\function_exists(\ConfigTransformer202202152\Symfony\Component\String\b::class)) {
    function b(?string $string = '') : \ConfigTransformer202202152\Symfony\Component\String\ByteString
    {
        return new \ConfigTransformer202202152\Symfony\Component\String\ByteString($string ?? '');
    }
}
if (!\function_exists(\ConfigTransformer202202152\Symfony\Component\String\s::class)) {
    /**
     * @return UnicodeString|ByteString
     */
    function s(?string $string = '') : \ConfigTransformer202202152\Symfony\Component\String\AbstractString
    {
        $string = $string ?? '';
        return \preg_match('//u', $string) ? new \ConfigTransformer202202152\Symfony\Component\String\UnicodeString($string) : new \ConfigTransformer202202152\Symfony\Component\String\ByteString($string);
    }
}
