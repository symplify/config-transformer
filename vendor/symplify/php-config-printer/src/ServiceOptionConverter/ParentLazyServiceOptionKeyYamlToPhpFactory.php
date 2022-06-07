<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer2022060710\PhpParser\BuilderHelpers;
use ConfigTransformer2022060710\PhpParser\Node\Arg;
use ConfigTransformer2022060710\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2022060710\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2022060710\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ParentLazyServiceOptionKeyYamlToPhpFactory implements ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, MethodCall $methodCall) : MethodCall
    {
        $method = $key;
        $methodCall = new MethodCall($methodCall, $method);
        $methodCall->args[] = new Arg(BuilderHelpers::normalizeValue($values[$key]));
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [YamlKey::PARENT, YamlKey::LAZY], \true);
    }
}
