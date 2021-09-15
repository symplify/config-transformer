<?php

declare (strict_types=1);
namespace ConfigTransformer202109151\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202109151\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202109151\PhpParser\Node\Expr\Variable;
use ConfigTransformer202109151\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202109151\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202109151\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202109151\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202109151\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202109151\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ExtensionConverter implements \ConfigTransformer202109151\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
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
    public function __construct(\ConfigTransformer202109151\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer202109151\Symplify\PhpConfigPrinter\ValueObject\YamlKey $yamlKey)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->yamlKey = $yamlKey;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer202109151\PhpParser\Node\Stmt\Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$this->rootKey, [$key => $values]]);
        $containerConfiguratorVariable = new \ConfigTransformer202109151\PhpParser\Node\Expr\Variable(\ConfigTransformer202109151\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $methodCall = new \ConfigTransformer202109151\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, \ConfigTransformer202109151\Symplify\PhpConfigPrinter\ValueObject\MethodName::EXTENSION, $args);
        return new \ConfigTransformer202109151\PhpParser\Node\Stmt\Expression($methodCall);
    }
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool
    {
        $this->rootKey = $rootKey;
        return !\in_array($rootKey, $this->yamlKey->provideRootKeys(), \true);
    }
}
