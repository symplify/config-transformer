<?php

declare (strict_types=1);
namespace ConfigTransformer20210610\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer20210610\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer20210610\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer20210610\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
final class SharedPublicServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer20210610\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer20210610\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer20210610\PhpParser\Node\Expr\MethodCall
    {
        if ($key === 'public') {
            if ($yaml === \false) {
                return new \ConfigTransformer20210610\PhpParser\Node\Expr\MethodCall($methodCall, 'private');
            }
            return new \ConfigTransformer20210610\PhpParser\Node\Expr\MethodCall($methodCall, 'public');
        }
        throw new \ConfigTransformer20210610\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, ['shared', 'public'], \true);
    }
}
