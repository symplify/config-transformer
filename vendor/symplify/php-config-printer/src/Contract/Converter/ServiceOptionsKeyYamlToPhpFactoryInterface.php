<?php

declare (strict_types=1);
namespace ConfigTransformer2021070710\Symplify\PhpConfigPrinter\Contract\Converter;

use ConfigTransformer2021070710\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer2021070710\PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \ConfigTransformer2021070710\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
