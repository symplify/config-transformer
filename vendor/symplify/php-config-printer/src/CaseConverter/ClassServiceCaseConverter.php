<?php

declare (strict_types=1);
namespace ConfigTransformer202206077\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202206077\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202206077\PhpParser\Node\Expr\Variable;
use ConfigTransformer202206077\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ClassServiceCaseConverter implements CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(ArgsNodeFactory $argsNodeFactory, ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$key, $values[YamlKey::CLASS_KEY]]);
        $methodCall = new MethodCall(new Variable(VariableName::SERVICES), MethodName::SET, $args);
        unset($values[YamlKey::CLASS_KEY]);
        $decoratedMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $methodCall);
        return new Expression($decoratedMethodCall);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== YamlKey::SERVICES) {
            return \false;
        }
        if (\is_array($values) && \count($values) !== 1) {
            return \false;
        }
        if (!isset($values[YamlKey::CLASS_KEY])) {
            return \false;
        }
        return !isset($values[YamlKey::ALIAS]);
    }
}
