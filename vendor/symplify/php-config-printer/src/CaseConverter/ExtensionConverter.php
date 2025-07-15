<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformerPrefix202507\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202507\PhpParser\Node\Expr\Variable;
use ConfigTransformerPrefix202507\PhpParser\Node\Stmt;
use ConfigTransformerPrefix202507\PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\MethodName;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ExtensionConverter implements CaseConverterInterface
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var string|null
     */
    private $rootKey;
    public function __construct(ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCallStmt($key, $values) : Stmt
    {
        $args = $this->argsNodeFactory->createFromValues([$this->rootKey, [$key => $values]]);
        $containerConfiguratorVariable = new Variable(VariableName::CONTAINER_CONFIGURATOR);
        $methodCall = new MethodCall($containerConfiguratorVariable, MethodName::EXTENSION, $args);
        return new Expression($methodCall);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function match(string $rootKey, $key, $values) : bool
    {
        $this->rootKey = $rootKey;
        return !\in_array($rootKey, YamlKey::provideRootKeys(), \true);
    }
}
