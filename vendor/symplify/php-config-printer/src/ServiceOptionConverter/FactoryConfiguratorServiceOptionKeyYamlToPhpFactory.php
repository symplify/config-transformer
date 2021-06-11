<?php

declare (strict_types=1);
namespace ConfigTransformer202106111\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202106111\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202106111\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202106111\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202106111\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class FactoryConfiguratorServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202106111\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer202106111\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202106111\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202106111\PhpParser\Node\Expr\MethodCall
    {
        $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($yaml);
        return new \ConfigTransformer202106111\PhpParser\Node\Expr\MethodCall($methodCall, 'factory', $args);
    }
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer202106111\Symplify\PhpConfigPrinter\ValueObject\YamlKey::FACTORY, \ConfigTransformer202106111\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CONFIGURATOR], \true);
    }
}
