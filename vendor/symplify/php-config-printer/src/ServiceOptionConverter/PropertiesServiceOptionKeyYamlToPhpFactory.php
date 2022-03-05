<?php

declare (strict_types=1);
namespace ConfigTransformer202203058\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202203058\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202203058\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202203058\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory;
use ConfigTransformer202203058\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class PropertiesServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202203058\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;
    public function __construct(\ConfigTransformer202203058\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory $singleServicePhpNodeFactory)
    {
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed|mixed[] $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202203058\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202203058\PhpParser\Node\Expr\MethodCall
    {
        return $this->singleServicePhpNodeFactory->createProperties($methodCall, $yaml);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer202203058\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::PROPERTIES;
    }
}
