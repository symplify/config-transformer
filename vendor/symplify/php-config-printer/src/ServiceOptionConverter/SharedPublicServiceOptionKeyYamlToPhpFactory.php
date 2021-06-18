<?php

declare (strict_types=1);
namespace ConfigTransformer202106183\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202106183\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202106183\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202106183\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
final class SharedPublicServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202106183\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202106183\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202106183\PhpParser\Node\Expr\MethodCall
    {
        if ($key === 'public') {
            if ($yaml === \false) {
                return new \ConfigTransformer202106183\PhpParser\Node\Expr\MethodCall($methodCall, 'private');
            }
            return new \ConfigTransformer202106183\PhpParser\Node\Expr\MethodCall($methodCall, 'public');
        }
        throw new \ConfigTransformer202106183\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, ['shared', 'public'], \true);
    }
}
