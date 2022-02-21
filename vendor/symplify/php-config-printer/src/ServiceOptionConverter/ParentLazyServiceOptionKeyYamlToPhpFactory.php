<?php

declare (strict_types=1);
namespace ConfigTransformer202202215\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202202215\PhpParser\BuilderHelpers;
use ConfigTransformer202202215\PhpParser\Node\Arg;
use ConfigTransformer202202215\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202202215\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202202215\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ParentLazyServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202202215\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202202215\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202202215\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        $methodCall = new \ConfigTransformer202202215\PhpParser\Node\Expr\MethodCall($methodCall, $method);
        $methodCall->args[] = new \ConfigTransformer202202215\PhpParser\Node\Arg(\ConfigTransformer202202215\PhpParser\BuilderHelpers::normalizeValue($values[$key]));
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer202202215\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARENT, \ConfigTransformer202202215\Symplify\PhpConfigPrinter\ValueObject\YamlKey::LAZY], \true);
    }
}
