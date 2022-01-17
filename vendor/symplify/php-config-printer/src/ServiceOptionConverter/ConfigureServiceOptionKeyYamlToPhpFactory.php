<?php

declare (strict_types=1);
namespace ConfigTransformer202201175\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202201175\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202201175\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202201175\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory;
final class ConfigureServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202201175\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;
    public function __construct(\ConfigTransformer202201175\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory $singleServicePhpNodeFactory)
    {
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202201175\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202201175\PhpParser\Node\Expr\MethodCall
    {
        return $this->singleServicePhpNodeFactory->createCalls($methodCall, $yaml, \true);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return $key === 'configure';
    }
}
