<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210\Symplify\PhpConfigPrinter\RoutingCaseConverter;

use ConfigTransformer2022052210\PhpParser\Node\Arg;
use ConfigTransformer2022052210\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2022052210\PhpParser\Node\Expr\Variable;
use ConfigTransformer2022052210\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2022052210\Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use ConfigTransformer2022052210\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class PathRoutingCaseConverter implements \ConfigTransformer2022052210\Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface
{
    /**
     * @var string[]
     */
    private const NESTED_KEYS = ['controller', 'defaults', self::METHODS, 'requirements'];
    /**
     * @var string
     */
    private const PATH = 'path';
    /**
     * @var string
     */
    private const METHODS = 'methods';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer2022052210\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool
    {
        return isset($values[self::PATH]);
    }
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer2022052210\PhpParser\Node\Stmt\Expression
    {
        $variable = new \ConfigTransformer2022052210\PhpParser\Node\Expr\Variable(\ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\VariableName::ROUTING_CONFIGURATOR);
        // @todo args
        $args = $this->createAddArgs($key, $values);
        $methodCall = new \ConfigTransformer2022052210\PhpParser\Node\Expr\MethodCall($variable, 'add', $args);
        foreach (self::NESTED_KEYS as $nestedKey) {
            if (!isset($values[$nestedKey])) {
                continue;
            }
            $nestedValues = $values[$nestedKey];
            // Transform methods as string GET|HEAD to array
            if ($nestedKey === self::METHODS && \is_string($nestedValues)) {
                $nestedValues = \explode('|', $nestedValues);
            }
            $args = $this->argsNodeFactory->createFromValues([$nestedValues]);
            $methodCall = new \ConfigTransformer2022052210\PhpParser\Node\Expr\MethodCall($methodCall, $nestedKey, $args);
        }
        return new \ConfigTransformer2022052210\PhpParser\Node\Stmt\Expression($methodCall);
    }
    /**
     * @return Arg[]
     * @param mixed $values
     */
    private function createAddArgs(string $key, $values) : array
    {
        $argumentValues = [];
        $argumentValues[] = $key;
        if (isset($values[self::PATH])) {
            $argumentValues[] = $values[self::PATH];
        }
        return $this->argsNodeFactory->createFromValues($argumentValues);
    }
}
