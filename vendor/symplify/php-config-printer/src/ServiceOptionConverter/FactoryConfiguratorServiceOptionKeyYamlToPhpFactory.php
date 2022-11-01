<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202211\PhpParser\Node\Expr\MethodCall;
use Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use Symplify\PhpConfigPrinter\ServiceOptionConverter\NodeModifier\SingleFactoryReferenceNodeModifier;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class FactoryConfiguratorServiceOptionKeyYamlToPhpFactory implements ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\ServiceOptionConverter\NodeModifier\SingleFactoryReferenceNodeModifier
     */
    private $singleFactoryReferenceNodeModifier;
    public function __construct(ArgsNodeFactory $argsNodeFactory, SingleFactoryReferenceNodeModifier $singleFactoryReferenceNodeModifier)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->singleFactoryReferenceNodeModifier = $singleFactoryReferenceNodeModifier;
    }
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, MethodCall $methodCall) : MethodCall
    {
        $args = \is_array($yaml) || \strpos($yaml, ':') !== \false ? $this->argsNodeFactory->createFromValuesAndWrapInArray($yaml) : $this->argsNodeFactory->createFromValues($yaml);
        $this->singleFactoryReferenceNodeModifier->modifyArgs($args);
        return new MethodCall($methodCall, 'factory', $args);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [YamlKey::FACTORY, YamlKey::CONFIGURATOR], \true);
    }
}
