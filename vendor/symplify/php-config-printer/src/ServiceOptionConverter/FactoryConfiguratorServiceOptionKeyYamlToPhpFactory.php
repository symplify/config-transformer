<?php

declare (strict_types=1);
namespace ConfigTransformer202201264\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202201264\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202201264\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202201264\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202201264\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class FactoryConfiguratorServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202201264\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer202201264\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202201264\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202201264\PhpParser\Node\Expr\MethodCall
    {
        $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($yaml);
        return new \ConfigTransformer202201264\PhpParser\Node\Expr\MethodCall($methodCall, 'factory', $args);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer202201264\Symplify\PhpConfigPrinter\ValueObject\YamlKey::FACTORY, \ConfigTransformer202201264\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CONFIGURATOR], \true);
    }
}
