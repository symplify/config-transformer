<?php

declare (strict_types=1);
namespace ConfigTransformer202107130\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202107130\PhpParser\BuilderHelpers;
use ConfigTransformer202107130\PhpParser\Node\Arg;
use ConfigTransformer202107130\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202107130\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202107130\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ParentLazyServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202107130\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yaml, $values, $methodCall) : \ConfigTransformer202107130\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        $methodCall = new \ConfigTransformer202107130\PhpParser\Node\Expr\MethodCall($methodCall, $method);
        $methodCall->args[] = new \ConfigTransformer202107130\PhpParser\Node\Arg(\ConfigTransformer202107130\PhpParser\BuilderHelpers::normalizeValue($values[$key]));
        return $methodCall;
    }
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer202107130\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARENT, \ConfigTransformer202107130\Symplify\PhpConfigPrinter\ValueObject\YamlKey::LAZY], \true);
    }
}
