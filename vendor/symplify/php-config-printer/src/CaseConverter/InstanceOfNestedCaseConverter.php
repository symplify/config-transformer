<?php

declare (strict_types=1);
namespace ConfigTransformer202109287\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202109287\PhpParser\Node\Arg;
use ConfigTransformer202109287\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202109287\PhpParser\Node\Expr\Variable;
use ConfigTransformer202109287\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202109287\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202109287\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use ConfigTransformer202109287\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202109287\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202109287\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
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
    public function __construct(\ConfigTransformer202109287\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \ConfigTransformer202109287\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall(string $key, array $values) : \ConfigTransformer202109287\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $servicesVariable = new \ConfigTransformer202109287\PhpParser\Node\Expr\Variable(\ConfigTransformer202109287\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        $args = [new \ConfigTransformer202109287\PhpParser\Node\Arg($classConstFetch)];
        $instanceofMethodCall = new \ConfigTransformer202109287\PhpParser\Node\Expr\MethodCall($servicesVariable, \ConfigTransformer202109287\Symplify\PhpConfigPrinter\ValueObject\MethodName::INSTANCEOF, $args);
        $decoreatedInstanceofMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $instanceofMethodCall);
        return new \ConfigTransformer202109287\PhpParser\Node\Stmt\Expression($decoreatedInstanceofMethodCall);
    }
    public function isMatch(string $rootKey, $subKey) : bool
    {
        if ($rootKey !== \ConfigTransformer202109287\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (!\is_string($subKey)) {
            return \false;
        }
        return $subKey === \ConfigTransformer202109287\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_INSTANCEOF;
    }
}
