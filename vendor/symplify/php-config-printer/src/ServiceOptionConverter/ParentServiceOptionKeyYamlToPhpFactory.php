<?php

declare (strict_types=1);
namespace ConfigTransformer202107132\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202107132\PhpParser\BuilderHelpers;
use ConfigTransformer202107132\PhpParser\Node\Arg;
use ConfigTransformer202107132\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202107132\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202107132\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ParentServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202107132\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yaml, $values, $methodCall) : \ConfigTransformer202107132\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        $methodCall = new \ConfigTransformer202107132\PhpParser\Node\Expr\MethodCall($methodCall, $method);
        $methodCall->args[] = new \ConfigTransformer202107132\PhpParser\Node\Arg(\ConfigTransformer202107132\PhpParser\BuilderHelpers::normalizeValue($values[$key]));
        return $methodCall;
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer202107132\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARENT;
    }
}
