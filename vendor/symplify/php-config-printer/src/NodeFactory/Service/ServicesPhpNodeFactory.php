<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformerPrefix202301\PhpParser\Node\Arg;
use ConfigTransformerPrefix202301\PhpParser\Node\Expr;
use ConfigTransformerPrefix202301\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202301\PhpParser\Node\Expr\Variable;
use ConfigTransformerPrefix202301\PhpParser\Node\Scalar\String_;
use ConfigTransformerPrefix202301\PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class ServicesPhpNodeFactory
{
    /**
     * @var string
     */
    private const EXCLUDE = 'exclude';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(CommonNodeFactory $commonNodeFactory, ArgsNodeFactory $argsNodeFactory, \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    /**
     * @param mixed[] $serviceValues
     */
    public function createResource(string $serviceKey, array $serviceValues) : Expression
    {
        $servicesLoadMethodCall = $this->createServicesLoadMethodCall($serviceKey, $serviceValues);
        $decoratedMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($serviceValues, $servicesLoadMethodCall);
        if (!isset($serviceValues[self::EXCLUDE])) {
            return new Expression($decoratedMethodCall);
        }
        $exclude = $serviceValues[self::EXCLUDE];
        if (!\is_array($exclude)) {
            $exclude = [$exclude];
        }
        /** @var array<int, Expr> $excludeValue */
        $excludeValue = [];
        foreach ($exclude as $key => $singleExclude) {
            $excludeValue[$key] = $this->commonNodeFactory->createAbsoluteDirExpr($singleExclude);
        }
        $args = $this->argsNodeFactory->createFromValues([$excludeValue]);
        $excludeMethodCall = new MethodCall($decoratedMethodCall, self::EXCLUDE, $args);
        return new Expression($excludeMethodCall);
    }
    /**
     * @param mixed[] $serviceValues
     */
    private function createServicesLoadMethodCall(string $serviceKey, array $serviceValues) : MethodCall
    {
        $servicesVariable = new Variable(VariableName::SERVICES);
        $resource = $serviceValues['resource'];
        $args = [];
        $args[] = new Arg(new String_($serviceKey));
        $args[] = new Arg($this->commonNodeFactory->createAbsoluteDirExpr($resource));
        return new MethodCall($servicesVariable, 'load', $args);
    }
}
