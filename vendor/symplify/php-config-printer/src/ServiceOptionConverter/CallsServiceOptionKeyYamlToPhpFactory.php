<?php

declare (strict_types=1);
namespace ConfigTransformer202112238\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202112238\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202112238\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202112238\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory;
use ConfigTransformer202112238\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class CallsServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202112238\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;
    public function __construct(\ConfigTransformer202112238\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory $singleServicePhpNodeFactory)
    {
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202112238\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202112238\PhpParser\Node\Expr\MethodCall
    {
        return $this->singleServicePhpNodeFactory->createCalls($methodCall, $yaml, \false);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer202112238\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::CALLS;
    }
}
