<?php

declare (strict_types=1);
namespace ConfigTransformer202106129\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202106129\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202106129\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202106129\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory;
use ConfigTransformer202106129\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class CallsServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202106129\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;
    public function __construct(\ConfigTransformer202106129\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory $singleServicePhpNodeFactory)
    {
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202106129\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202106129\PhpParser\Node\Expr\MethodCall
    {
        return $this->singleServicePhpNodeFactory->createCalls($methodCall, $yaml);
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer202106129\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::CALLS;
    }
}
