<?php

declare (strict_types=1);
namespace ConfigTransformer202201159\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202201159\PhpParser\BuilderHelpers;
use ConfigTransformer202201159\PhpParser\Node\Arg;
use ConfigTransformer202201159\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202201159\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202201159\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ParentLazyServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202201159\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202201159\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202201159\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        $methodCall = new \ConfigTransformer202201159\PhpParser\Node\Expr\MethodCall($methodCall, $method);
        $methodCall->args[] = new \ConfigTransformer202201159\PhpParser\Node\Arg(\ConfigTransformer202201159\PhpParser\BuilderHelpers::normalizeValue($values[$key]));
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer202201159\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARENT, \ConfigTransformer202201159\Symplify\PhpConfigPrinter\ValueObject\YamlKey::LAZY], \true);
    }
}
