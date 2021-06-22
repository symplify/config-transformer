<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer2021062210\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
final class SharedPublicServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer2021062210\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer2021062210\PhpParser\Node\Expr\MethodCall
    {
        if ($key === 'public') {
            if ($yaml === \false) {
                return new \ConfigTransformer2021062210\PhpParser\Node\Expr\MethodCall($methodCall, 'private');
            }
            return new \ConfigTransformer2021062210\PhpParser\Node\Expr\MethodCall($methodCall, 'public');
        }
        throw new \ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, ['shared', 'public'], \true);
    }
}
