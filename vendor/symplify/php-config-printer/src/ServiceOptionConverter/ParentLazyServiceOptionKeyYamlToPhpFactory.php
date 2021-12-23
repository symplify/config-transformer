<?php

declare (strict_types=1);
namespace ConfigTransformer2021122310\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer2021122310\PhpParser\BuilderHelpers;
use ConfigTransformer2021122310\PhpParser\Node\Arg;
use ConfigTransformer2021122310\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021122310\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2021122310\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ParentLazyServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer2021122310\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer2021122310\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer2021122310\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        $methodCall = new \ConfigTransformer2021122310\PhpParser\Node\Expr\MethodCall($methodCall, $method);
        $methodCall->args[] = new \ConfigTransformer2021122310\PhpParser\Node\Arg(\ConfigTransformer2021122310\PhpParser\BuilderHelpers::normalizeValue($values[$key]));
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer2021122310\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARENT, \ConfigTransformer2021122310\Symplify\PhpConfigPrinter\ValueObject\YamlKey::LAZY], \true);
    }
}
