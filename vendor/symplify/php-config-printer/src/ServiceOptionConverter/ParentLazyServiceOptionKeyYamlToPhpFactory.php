<?php

declare (strict_types=1);
namespace ConfigTransformer202203051\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202203051\PhpParser\BuilderHelpers;
use ConfigTransformer202203051\PhpParser\Node\Arg;
use ConfigTransformer202203051\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202203051\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202203051\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ParentLazyServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202203051\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed|mixed[] $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202203051\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202203051\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        $methodCall = new \ConfigTransformer202203051\PhpParser\Node\Expr\MethodCall($methodCall, $method);
        $methodCall->args[] = new \ConfigTransformer202203051\PhpParser\Node\Arg(\ConfigTransformer202203051\PhpParser\BuilderHelpers::normalizeValue($values[$key]));
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer202203051\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARENT, \ConfigTransformer202203051\Symplify\PhpConfigPrinter\ValueObject\YamlKey::LAZY], \true);
    }
}
