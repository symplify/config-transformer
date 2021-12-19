<?php

declare (strict_types=1);
namespace ConfigTransformer202112194\Symplify\PhpConfigPrinter\Contract\Converter;

use ConfigTransformer202112194\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202112194\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202112194\PhpParser\Node\Expr\MethodCall;
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool;
}
