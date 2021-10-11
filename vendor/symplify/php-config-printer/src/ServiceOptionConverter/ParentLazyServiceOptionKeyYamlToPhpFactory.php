<?php

declare (strict_types=1);
namespace ConfigTransformer2021101110\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer2021101110\PhpParser\BuilderHelpers;
use ConfigTransformer2021101110\PhpParser\Node\Arg;
use ConfigTransformer2021101110\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021101110\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2021101110\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ParentLazyServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer2021101110\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yaml, $values, $methodCall) : \ConfigTransformer2021101110\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        $methodCall = new \ConfigTransformer2021101110\PhpParser\Node\Expr\MethodCall($methodCall, $method);
        $methodCall->args[] = new \ConfigTransformer2021101110\PhpParser\Node\Arg(\ConfigTransformer2021101110\PhpParser\BuilderHelpers::normalizeValue($values[$key]));
        return $methodCall;
    }
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer2021101110\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARENT, \ConfigTransformer2021101110\Symplify\PhpConfigPrinter\ValueObject\YamlKey::LAZY], \true);
    }
}
