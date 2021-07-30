<?php

declare (strict_types=1);
namespace ConfigTransformer202107300\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202107300\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202107300\PhpParser\Node\Expr\Variable;
use ConfigTransformer202107300\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202107300\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202107300\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202107300\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use ConfigTransformer202107300\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202107300\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202107300\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ClassServiceCaseConverter implements \ConfigTransformer202107300\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\ConfigTransformer202107300\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer202107300\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer202107300\PhpParser\Node\Stmt\Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$key, $values[\ConfigTransformer202107300\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY]]);
        $methodCall = new \ConfigTransformer202107300\PhpParser\Node\Expr\MethodCall(new \ConfigTransformer202107300\PhpParser\Node\Expr\Variable(\ConfigTransformer202107300\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), \ConfigTransformer202107300\Symplify\PhpConfigPrinter\ValueObject\MethodName::SET, $args);
        unset($values[\ConfigTransformer202107300\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY]);
        $decoratedMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $methodCall);
        return new \ConfigTransformer202107300\PhpParser\Node\Stmt\Expression($decoratedMethodCall);
    }
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer202107300\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (\is_array($values) && \count($values) !== 1) {
            return \false;
        }
        if (!isset($values[\ConfigTransformer202107300\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY])) {
            return \false;
        }
        return !isset($values[\ConfigTransformer202107300\Symplify\PhpConfigPrinter\ValueObject\YamlKey::ALIAS]);
    }
}
