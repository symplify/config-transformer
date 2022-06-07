<?php

declare (strict_types=1);
namespace ConfigTransformer202206077\Symplify\PhpConfigPrinter\CaseConverter\NestedCaseConverter;

use ConfigTransformer202206077\PhpParser\Node\Arg;
use ConfigTransformer202206077\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202206077\PhpParser\Node\Expr\Variable;
use ConfigTransformer202206077\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class InstanceOfNestedCaseConverter
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(CommonNodeFactory $commonNodeFactory, ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    /**
     * @param mixed[] $values
     */
    public function convertToMethodCall(string $key, array $values) : Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $servicesVariable = new Variable(VariableName::SERVICES);
        $args = [new Arg($classConstFetch)];
        $instanceofMethodCall = new MethodCall($servicesVariable, MethodName::INSTANCEOF, $args);
        $decoreatedInstanceofMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $instanceofMethodCall);
        return new Expression($decoreatedInstanceofMethodCall);
    }
    /**
     * @param mixed $subKey
     */
    public function isMatch(string $rootKey, $subKey) : bool
    {
        if ($rootKey !== YamlKey::SERVICES) {
            return \false;
        }
        if (!\is_string($subKey)) {
            return \false;
        }
        return $subKey === YamlKey::_INSTANCEOF;
    }
}
