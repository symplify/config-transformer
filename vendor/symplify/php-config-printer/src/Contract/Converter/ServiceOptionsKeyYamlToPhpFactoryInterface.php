<?php

declare (strict_types=1);
namespace ConfigTransformer202110016\Symplify\PhpConfigPrinter\Contract\Converter;

use ConfigTransformer202110016\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yaml, $values, $methodCall) : \ConfigTransformer202110016\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
