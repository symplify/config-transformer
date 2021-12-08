<?php

declare (strict_types=1);
namespace ConfigTransformer2021120810\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer2021120810\PhpParser\Node\Arg;
use ConfigTransformer2021120810\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021120810\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2021120810\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
use ConfigTransformer2021120810\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
final class SharedPublicServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer2021120810\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\ConfigTransformer2021120810\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yaml, $values, $methodCall) : \ConfigTransformer2021120810\PhpParser\Node\Expr\MethodCall
    {
        if ($key === 'public') {
            if ($yaml === \false) {
                return new \ConfigTransformer2021120810\PhpParser\Node\Expr\MethodCall($methodCall, 'private');
            }
            return new \ConfigTransformer2021120810\PhpParser\Node\Expr\MethodCall($methodCall, 'public');
        }
        if ($key === 'shared') {
            if ($yaml === \false) {
                return new \ConfigTransformer2021120810\PhpParser\Node\Expr\MethodCall($methodCall, 'share', [new \ConfigTransformer2021120810\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())]);
            }
            return new \ConfigTransformer2021120810\PhpParser\Node\Expr\MethodCall($methodCall, 'share');
        }
        throw new \ConfigTransformer2021120810\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, ['shared', 'public'], \true);
    }
}
