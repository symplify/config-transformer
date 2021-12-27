<?php

declare (strict_types=1);
namespace ConfigTransformer202112273\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202112273\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202112273\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202112273\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory;
final class ConfigureServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202112273\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;
    public function __construct(\ConfigTransformer202112273\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory $singleServicePhpNodeFactory)
    {
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202112273\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202112273\PhpParser\Node\Expr\MethodCall
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
