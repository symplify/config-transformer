<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\CaseConverter\NestedCaseConverter;

use ConfigTransformerPrefix202507\PhpParser\Node\Arg;
use ConfigTransformerPrefix202507\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202507\PhpParser\Node\Expr\Variable;
use ConfigTransformerPrefix202507\PhpParser\Node\Stmt;
use ConfigTransformerPrefix202507\PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\MethodName;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class InstanceOfNestedCaseConverter
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @readonly
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
    public function convertToMethodCall(string $key, array $values) : Stmt
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $servicesVariable = new Variable(VariableName::SERVICES);
        $args = [new Arg($classConstFetch)];
        $instanceofMethodCall = new MethodCall($servicesVariable, MethodName::INSTANCEOF, $args);
        $decoreatedInstanceofMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $instanceofMethodCall);
        return new Expression($decoreatedInstanceofMethodCall);
    }
    /**
     * @param int|string $subKey
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
