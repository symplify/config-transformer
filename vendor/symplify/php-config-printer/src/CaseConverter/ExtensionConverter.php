<?php

declare (strict_types=1);
namespace ConfigTransformer202112118\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202112118\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202112118\PhpParser\Node\Expr\Variable;
use ConfigTransformer202112118\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202112118\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202112118\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202112118\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202112118\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202112118\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ExtensionConverter implements \ConfigTransformer202112118\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var string|null
     */
    private $rootKey;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer202112118\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202112118\PhpParser\Node\Stmt\Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$this->rootKey, [$key => $values]]);
        $containerConfiguratorVariable = new \ConfigTransformer202112118\PhpParser\Node\Expr\Variable(\ConfigTransformer202112118\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $methodCall = new \ConfigTransformer202112118\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, \ConfigTransformer202112118\Symplify\PhpConfigPrinter\ValueObject\MethodName::EXTENSION, $args);
        return new \ConfigTransformer202112118\PhpParser\Node\Stmt\Expression($methodCall);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function match(string $rootKey, $key, $values) : bool
    {
        $this->rootKey = $rootKey;
        return !\in_array($rootKey, \ConfigTransformer202112118\Symplify\PhpConfigPrinter\ValueObject\YamlKey::provideRootKeys(), \true);
    }
}
