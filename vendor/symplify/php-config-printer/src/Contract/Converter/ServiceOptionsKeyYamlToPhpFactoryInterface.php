<?php

declare (strict_types=1);
namespace ConfigTransformer202205212\Symplify\PhpConfigPrinter\Contract\Converter;

use ConfigTransformer202205212\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202205212\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202205212\PhpParser\Node\Expr\MethodCall;
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool;
}
