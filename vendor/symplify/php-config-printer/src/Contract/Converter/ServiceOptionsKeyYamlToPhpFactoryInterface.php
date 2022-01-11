<?php

declare (strict_types=1);
namespace ConfigTransformer2022011110\Symplify\PhpConfigPrinter\Contract\Converter;

use ConfigTransformer2022011110\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer2022011110\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer2022011110\PhpParser\Node\Expr\MethodCall;
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool;
}
