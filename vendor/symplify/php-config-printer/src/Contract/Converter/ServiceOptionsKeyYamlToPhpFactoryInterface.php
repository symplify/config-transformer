<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\Symplify\PhpConfigPrinter\Contract\Converter;

use ConfigTransformer20210606\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer20210606\PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \ConfigTransformer20210606\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
