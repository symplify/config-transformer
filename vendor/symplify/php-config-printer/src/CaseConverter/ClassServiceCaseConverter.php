<?php

declare (strict_types=1);
namespace ConfigTransformer202204179\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202204179\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202204179\PhpParser\Node\Expr\Variable;
use ConfigTransformer202204179\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202204179\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202204179\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202204179\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use ConfigTransformer202204179\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202204179\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202204179\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ClassServiceCaseConverter implements \ConfigTransformer202204179\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\ConfigTransformer202204179\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer202204179\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202204179\PhpParser\Node\Stmt\Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$key, $values[\ConfigTransformer202204179\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY]]);
        $methodCall = new \ConfigTransformer202204179\PhpParser\Node\Expr\MethodCall(new \ConfigTransformer202204179\PhpParser\Node\Expr\Variable(\ConfigTransformer202204179\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), \ConfigTransformer202204179\Symplify\PhpConfigPrinter\ValueObject\MethodName::SET, $args);
        unset($values[\ConfigTransformer202204179\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY]);
        $decoratedMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $methodCall);
        return new \ConfigTransformer202204179\PhpParser\Node\Stmt\Expression($decoratedMethodCall);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer202204179\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (\is_array($values) && \count($values) !== 1) {
            return \false;
        }
        if (!isset($values[\ConfigTransformer202204179\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY])) {
            return \false;
        }
        return !isset($values[\ConfigTransformer202204179\Symplify\PhpConfigPrinter\ValueObject\YamlKey::ALIAS]);
    }
}
