<?php

declare (strict_types=1);
namespace ConfigTransformer202106114\Symplify\PhpConfigPrinter\Contract\Converter;

use ConfigTransformer202106114\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202106114\PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \ConfigTransformer202106114\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
