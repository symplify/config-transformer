<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer2021062210\PhpParser\Node\Arg;
use ConfigTransformer2021062210\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class BindAutowireAutoconfigureServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\ConfigTransformer2021062210\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer2021062210\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer2021062210\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        if ($key === 'shared') {
            $method = 'share';
        }
        $methodCall = new \ConfigTransformer2021062210\PhpParser\Node\Expr\MethodCall($methodCall, $method);
        if ($yaml === \false) {
            $methodCall->args[] = new \ConfigTransformer2021062210\PhpParser\Node\Arg($this->commonNodeFactory->createFalse());
        }
        return $methodCall;
    }
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::BIND, \ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE, \ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE], \true);
    }
}
