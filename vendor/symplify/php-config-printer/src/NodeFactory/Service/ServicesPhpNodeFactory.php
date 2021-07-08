<?php

declare (strict_types=1);
namespace ConfigTransformer202107084\Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformer202107084\PhpParser\Node\Arg;
use ConfigTransformer202107084\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202107084\PhpParser\Node\Expr\Variable;
use ConfigTransformer202107084\PhpParser\Node\Scalar\String_;
use ConfigTransformer202107084\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202107084\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202107084\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202107084\Symplify\PhpConfigPrinter\ValueObject\VariableName;
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
    public function __construct(\ConfigTransformer202107084\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \ConfigTransformer202107084\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer202107084\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function createResource(string $serviceKey, array $serviceValues) : \ConfigTransformer202107084\PhpParser\Node\Stmt\Expression
    {
        $servicesLoadMethodCall = $this->createServicesLoadMethodCall($serviceKey, $serviceValues);
        $servicesLoadMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($serviceValues, $servicesLoadMethodCall);
        if (!isset($serviceValues[self::EXCLUDE])) {
            return new \ConfigTransformer202107084\PhpParser\Node\Stmt\Expression($servicesLoadMethodCall);
        }
        $exclude = $serviceValues[self::EXCLUDE];
        if (!\is_array($exclude)) {
            $exclude = [$exclude];
        }
        $excludeValue = [];
        foreach ($exclude as $key => $singleExclude) {
            $excludeValue[$key] = $this->commonNodeFactory->createAbsoluteDirExpr($singleExclude);
        }
        $args = $this->argsNodeFactory->createFromValues([$excludeValue]);
        $excludeMethodCall = new \ConfigTransformer202107084\PhpParser\Node\Expr\MethodCall($servicesLoadMethodCall, self::EXCLUDE, $args);
        return new \ConfigTransformer202107084\PhpParser\Node\Stmt\Expression($excludeMethodCall);
    }
    private function createServicesLoadMethodCall(string $serviceKey, $serviceValues) : \ConfigTransformer202107084\PhpParser\Node\Expr\MethodCall
    {
        $servicesVariable = new \ConfigTransformer202107084\PhpParser\Node\Expr\Variable(\ConfigTransformer202107084\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        $resource = $serviceValues['resource'];
        $args = [];
        $args[] = new \ConfigTransformer202107084\PhpParser\Node\Arg(new \ConfigTransformer202107084\PhpParser\Node\Scalar\String_($serviceKey));
        $args[] = new \ConfigTransformer202107084\PhpParser\Node\Arg($this->commonNodeFactory->createAbsoluteDirExpr($resource));
        return new \ConfigTransformer202107084\PhpParser\Node\Expr\MethodCall($servicesVariable, 'load', $args);
    }
}
