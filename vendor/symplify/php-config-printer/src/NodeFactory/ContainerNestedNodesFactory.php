<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202211\PhpParser\Node\Stmt;
use Symplify\PhpConfigPrinter\CaseConverter\NestedCaseConverter\InstanceOfNestedCaseConverter;
final class ContainerNestedNodesFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\CaseConverter\NestedCaseConverter\InstanceOfNestedCaseConverter
     */
    private $instanceOfNestedCaseConverter;
    public function __construct(InstanceOfNestedCaseConverter $instanceOfNestedCaseConverter)
    {
        $this->instanceOfNestedCaseConverter = $instanceOfNestedCaseConverter;
    }
    /**
     * @api
     * @param mixed[] $nestedValues
     * @return Stmt[]
     * @param int|string $nestedKey
     */
    public function createFromValues(array $nestedValues, string $key, $nestedKey) : array
    {
        $nestedStmts = [];
        foreach ($nestedValues as $subNestedKey => $subNestedValue) {
            if (!$this->instanceOfNestedCaseConverter->isMatch($key, $nestedKey)) {
                continue;
            }
            $nestedStmts[] = $this->instanceOfNestedCaseConverter->convertToMethodCall($subNestedKey, $subNestedValue);
        }
        return $nestedStmts;
    }
}
