<?php

declare (strict_types=1);
namespace ConfigTransformer202109294\Symplify\PhpConfigPrinter\Contract\Converter;

use ConfigTransformer202109294\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yaml, $values, $methodCall) : \ConfigTransformer202109294\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
