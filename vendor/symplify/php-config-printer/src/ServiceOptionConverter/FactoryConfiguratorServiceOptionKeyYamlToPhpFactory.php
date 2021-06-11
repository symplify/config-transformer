<?php

declare (strict_types=1);
namespace ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer2021061110\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021061110\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2021061110\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class FactoryConfiguratorServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer2021061110\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer2021061110\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer2021061110\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer2021061110\PhpParser\Node\Expr\MethodCall
    {
        $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($yaml);
        return new \ConfigTransformer2021061110\PhpParser\Node\Expr\MethodCall($methodCall, 'factory', $args);
    }
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\YamlKey::FACTORY, \ConfigTransformer2021061110\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CONFIGURATOR], \true);
    }
}
