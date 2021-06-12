<?php

declare (strict_types=1);
namespace ConfigTransformer202106125\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202106125\PhpParser\Node\Arg;
use ConfigTransformer202106125\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202106125\PhpParser\Node\Expr\Variable;
use ConfigTransformer202106125\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202106125\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202106125\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use ConfigTransformer202106125\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202106125\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202106125\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class InstanceOfNestedCaseConverter
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\ConfigTransformer202106125\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \ConfigTransformer202106125\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer202106125\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $servicesVariable = new \ConfigTransformer202106125\PhpParser\Node\Expr\Variable(\ConfigTransformer202106125\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        $args = [new \ConfigTransformer202106125\PhpParser\Node\Arg($classConstFetch)];
        $instanceofMethodCall = new \ConfigTransformer202106125\PhpParser\Node\Expr\MethodCall($servicesVariable, \ConfigTransformer202106125\Symplify\PhpConfigPrinter\ValueObject\MethodName::INSTANCEOF, $args);
        $instanceofMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $instanceofMethodCall);
        return new \ConfigTransformer202106125\PhpParser\Node\Stmt\Expression($instanceofMethodCall);
    }
    public function isMatch(string $rootKey, $subKey) : bool
    {
        if ($rootKey !== \ConfigTransformer202106125\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (!\is_string($subKey)) {
            return \false;
        }
        return $subKey === \ConfigTransformer202106125\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_INSTANCEOF;
    }
}
