<?php

declare (strict_types=1);
namespace ConfigTransformer202203132\Symplify\PhpConfigPrinter\CaseConverter\NestedCaseConverter;

use ConfigTransformer202203132\PhpParser\Node\Arg;
use ConfigTransformer202203132\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202203132\PhpParser\Node\Expr\Variable;
use ConfigTransformer202203132\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202203132\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202203132\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use ConfigTransformer202203132\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202203132\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202203132\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
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
    public function __construct(\ConfigTransformer202203132\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \ConfigTransformer202203132\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    /**
     * @param mixed[] $values
     */
    public function convertToMethodCall(string $key, array $values) : \ConfigTransformer202203132\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $servicesVariable = new \ConfigTransformer202203132\PhpParser\Node\Expr\Variable(\ConfigTransformer202203132\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        $args = [new \ConfigTransformer202203132\PhpParser\Node\Arg($classConstFetch)];
        $instanceofMethodCall = new \ConfigTransformer202203132\PhpParser\Node\Expr\MethodCall($servicesVariable, \ConfigTransformer202203132\Symplify\PhpConfigPrinter\ValueObject\MethodName::INSTANCEOF, $args);
        $decoreatedInstanceofMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $instanceofMethodCall);
        return new \ConfigTransformer202203132\PhpParser\Node\Stmt\Expression($decoreatedInstanceofMethodCall);
    }
    /**
     * @param mixed $subKey
     */
    public function isMatch(string $rootKey, $subKey) : bool
    {
        if ($rootKey !== \ConfigTransformer202203132\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (!\is_string($subKey)) {
            return \false;
        }
        return $subKey === \ConfigTransformer202203132\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_INSTANCEOF;
    }
}
