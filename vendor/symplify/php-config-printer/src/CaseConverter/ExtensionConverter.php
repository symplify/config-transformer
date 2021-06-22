<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer2021062210\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021062210\PhpParser\Node\Expr\Variable;
use ConfigTransformer2021062210\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ExtensionConverter implements \ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var string|null
     */
    private $rootKey;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\ValueObject\YamlKey
     */
    private $yamlKey;
    public function __construct(\ConfigTransformer2021062210\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ValueObject\YamlKey $yamlKey)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->yamlKey = $yamlKey;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021062210\PhpParser\Node\Stmt\Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$this->rootKey, [$key => $values]]);
        $containerConfiguratorVariable = new \ConfigTransformer2021062210\PhpParser\Node\Expr\Variable(\ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $methodCall = new \ConfigTransformer2021062210\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, \ConfigTransformer2021062210\Symplify\PhpConfigPrinter\ValueObject\MethodName::EXTENSION, $args);
        return new \ConfigTransformer2021062210\PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        $this->rootKey = $rootKey;
        return !\in_array($rootKey, $this->yamlKey->provideRootKeys(), \true);
    }
}
