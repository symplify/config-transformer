<?php

declare (strict_types=1);
namespace ConfigTransformer202106124\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202106124\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202106124\PhpParser\Node\Expr\Variable;
use ConfigTransformer202106124\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202106124\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202106124\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202106124\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202106124\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202106124\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ExtensionConverter implements \ConfigTransformer202106124\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var string
     */
    private $rootKey;
    /**
     * @var YamlKey
     */
    private $yamlKey;
    public function __construct(\ConfigTransformer202106124\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer202106124\Symplify\PhpConfigPrinter\ValueObject\YamlKey $yamlKey)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->yamlKey = $yamlKey;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer202106124\PhpParser\Node\Stmt\Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$this->rootKey, [$key => $values]]);
        $containerConfiguratorVariable = new \ConfigTransformer202106124\PhpParser\Node\Expr\Variable(\ConfigTransformer202106124\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $methodCall = new \ConfigTransformer202106124\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, \ConfigTransformer202106124\Symplify\PhpConfigPrinter\ValueObject\MethodName::EXTENSION, $args);
        return new \ConfigTransformer202106124\PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        $this->rootKey = $rootKey;
        return !\in_array($rootKey, $this->yamlKey->provideRootKeys(), \true);
    }
}
