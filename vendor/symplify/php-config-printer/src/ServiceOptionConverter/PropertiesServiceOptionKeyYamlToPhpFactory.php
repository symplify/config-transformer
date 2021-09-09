<?php

declare (strict_types=1);
namespace ConfigTransformer202109091\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202109091\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202109091\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202109091\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory;
use ConfigTransformer202109091\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class PropertiesServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202109091\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;
    public function __construct(\ConfigTransformer202109091\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory $singleServicePhpNodeFactory)
    {
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yaml, $values, $methodCall) : \ConfigTransformer202109091\PhpParser\Node\Expr\MethodCall
    {
        return $this->singleServicePhpNodeFactory->createProperties($methodCall, $yaml);
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer202109091\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::PROPERTIES;
    }
}
