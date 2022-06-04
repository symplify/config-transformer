<?php

declare (strict_types=1);
namespace ConfigTransformer202206041\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202206041\PhpParser\BuilderHelpers;
use ConfigTransformer202206041\PhpParser\Node\Arg;
use ConfigTransformer202206041\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202206041\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202206041\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ParentLazyServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202206041\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202206041\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202206041\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        $methodCall = new \ConfigTransformer202206041\PhpParser\Node\Expr\MethodCall($methodCall, $method);
        $methodCall->args[] = new \ConfigTransformer202206041\PhpParser\Node\Arg(\ConfigTransformer202206041\PhpParser\BuilderHelpers::normalizeValue($values[$key]));
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer202206041\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARENT, \ConfigTransformer202206041\Symplify\PhpConfigPrinter\ValueObject\YamlKey::LAZY], \true);
    }
}
